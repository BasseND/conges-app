<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\LeaveBalance;
use App\Models\SpecialLeaveType;
use App\Models\Department;
use App\Models\LeaveBalanceAdjustment;
use App\Models\Leave;
use App\Services\LeaveBalanceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LeaveBalancesExport;
use Illuminate\Support\Str;

class LeaveBalanceAdminController extends Controller
{
    protected $leaveBalanceService;

    public function __construct(LeaveBalanceService $leaveBalanceService)
    {
        $this->middleware(['auth', 'role:hr_admin,admin']);
        $this->leaveBalanceService = $leaveBalanceService;
    }

    /**
     * Page principale d'administration des soldes de congés
     */
    public function index(Request $request)
    {
        $year = $request->get('year', now()->year);
        $departmentId = $request->get('department_id');
        $search = $request->get('search');

        // Statistiques générales
        $stats = $this->getGeneralStats($year);

        // Liste des utilisateurs avec leurs soldes
        $usersQuery = User::with(['department', 'leaveBalances' => function($query) use ($year) {
            $query->where('year', $year)->with('specialLeaveType');
        }])->where('is_active', true);

        if ($departmentId) {
            $usersQuery->where('department_id', $departmentId);
        }

        if ($search) {
            $usersQuery->where(function($query) use ($search) {
                $query->where('first_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('matricule', 'like', "%{$search}%");
            });
        }

        $users = $usersQuery->paginate(20);

        // Départements pour le filtre
        $departments = \App\Models\Department::orderBy('name')->get();

        // Types de congés
        $leaveTypes = SpecialLeaveType::where('is_active', true)->get();

        return view('admin.leave-balances.index', compact(
            'users', 'stats', 'departments', 'leaveTypes', 'year', 'departmentId', 'search'
        ));
    }

    /**
     * Dashboard des soldes de congés pour HR Admin
     */
    public function dashboard(Request $request)
    {
        $year = $request->get('year', now()->year);
        $departmentId = $request->get('department_id');
        $search = $request->get('search');

        // Statistiques générales
        $stats = $this->getGeneralStats($year);

        // Liste des utilisateurs avec leurs soldes
        $usersQuery = User::with(['department', 'leaveBalances' => function($query) use ($year) {
            $query->where('year', $year)->with('specialLeaveType');
        }])->where('is_active', true);

        if ($departmentId) {
            $usersQuery->where('department_id', $departmentId);
        }

        if ($search) {
            $usersQuery->where(function($query) use ($search) {
                $query->where('first_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('matricule', 'like', "%{$search}%");
            });
        }

        $users = $usersQuery->paginate(20);

        // Départements pour le filtre
        $departments = \App\Models\Department::orderBy('name')->get();

        // Types de congés
        $leaveTypes = SpecialLeaveType::where('is_active', true)->get();

        return view('admin.leave-balances.dashboard', compact(
            'users', 'stats', 'departments', 'leaveTypes', 'year', 'departmentId', 'search'
        ));
    }

    /**
     * Outils d'initialisation et de vérification
     */
    public function tools()
    {
        $stats = [
            'total_users' => User::where('is_active', true)->count(),
            'users_with_balances' => User::whereHas('leaveBalances')->count(),
            'total_balances' => LeaveBalance::count(),
            'leave_types' => SpecialLeaveType::where('is_active', true)->count(),
        ];

        $departments = Department::orderBy('name')
            ->get();

        return view('admin.leave-balances.tools', compact('stats', 'departments'));
    }

    /**
     * Recalculer les soldes à partir des congés approuvés
     */
    public function recalculate(Request $request)
    {
        $validated = $request->validate([
            'year' => 'required|integer|min:2000|max:' . (now()->year + 5),
            'user_id' => 'nullable|string', // peut être id numérique ou matricule
        ]);

        $year = (int) $validated['year'];
        $userFilter = $validated['user_id'] ?? null;

        try {
            DB::beginTransaction();

            // Déterminer les utilisateurs ciblés
            $usersQuery = User::query()->where('is_active', true);
            if (!empty($userFilter)) {
                if (is_numeric($userFilter)) {
                    $usersQuery->where('id', (int) $userFilter);
                } else {
                    $usersQuery->where('matricule', $userFilter);
                }
            }
            $users = $usersQuery->get();

            // Précharger les types avec solde
            $leaveTypes = SpecialLeaveType::withBalance()->where('is_active', true)->get();

            $processed = 0;
            $createdBalances = 0;

            foreach ($users as $user) {
                foreach ($leaveTypes as $leaveType) {
                    // Obtenir ou créer le solde pour l'année
                    $balance = LeaveBalance::firstOrCreate(
                        [
                            'user_id' => $user->id,
                            'special_leave_type_id' => $leaveType->id,
                            'year' => $year,
                        ],
                        [
                            'initial_balance' => $leaveType->duration_days ?? 0,
                            'current_balance' => $leaveType->duration_days ?? 0,
                            'used_balance' => 0,
                            'adjustment_balance' => 0,
                            'notes' => 'Solde créé lors du recalcul',
                        ]
                    );
                    if ($balance->wasRecentlyCreated) {
                        $createdBalances++;
                    }

                    // Calculer le total des jours approuvés pour ce type et cette année
                    $approvedLeaves = Leave::where('user_id', $user->id)
                        ->where('status', 'approved')
                        ->whereYear('start_date', $year)
                        ->where('special_leave_type_id', $leaveType->id)
                        ->get();

                    $usedDays = $approvedLeaves->sum('duration');

                    // Mettre à jour les champs used_balance et current_balance (on conserve adjustment_balance)
                    $balance->used_balance = (int) $usedDays;
                    $balance->current_balance = (int) ($balance->initial_balance - $balance->used_balance + $balance->adjustment_balance);
                    $balance->save();

                    $processed++;
                }
            }

            DB::commit();

            $message = "Recalcul terminé pour l'année {$year}. Enregistrements traités: {$processed}. Nouveaux soldes: {$createdBalances}.";

            if ($request->expectsJson() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'processed' => $processed,
                    'created' => $createdBalances,
                ]);
            }

            return redirect()->route('admin.leave-balances.tools')
                ->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur lors du recalcul des soldes', [
                'error' => $e->getMessage(),
                'year' => $year,
                'user_filter' => $userFilter,
            ]);

            if ($request->expectsJson() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors du recalcul : ' . $e->getMessage(),
                ], 500);
            }

            return redirect()->route('admin.leave-balances.tools')
                ->with('error', 'Erreur lors du recalcul : ' . $e->getMessage());
        }
    }

    /**
     * Initialiser les soldes pour tous les utilisateurs
     */
    public function initializeAll(Request $request)
    {
        $request->validate([
            'year' => 'required|integer|min:2020|max:2030',
            'force' => 'boolean',
            'department_id' => 'nullable|exists:departments,id'
        ]);

        $year = $request->year;
        // Accepter l'alias force_reinit en plus de force
        $force = $request->boolean('force') || $request->boolean('force_reinit');
        $departmentId = $request->get('department_id');
        $results = [];

        try {
            DB::beginTransaction();

            // Filtrer par département si fourni
            $usersQuery = User::where('is_active', true);
            if (!empty($departmentId)) {
                $usersQuery->where('department_id', $departmentId);
            }
            $users = $usersQuery->get();
            
            foreach ($users as $user) {
                $result = $this->leaveBalanceService->initializeUserBalances($user, $year, $force);
                $results[] = [
                    'user' => $user->first_name . ' ' . $user->last_name,
                    'initialized' => $result['initialized'],
                    'skipped' => $result['skipped']
                ];
            }

            DB::commit();

            // Contenu négocié: JSON pour requêtes AJAX/JSON, sinon redirection avec message
            if ($request->expectsJson() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Initialisation terminée avec succès',
                    'results' => $results
                ]);
            }

            $initializedTotal = array_sum(array_column($results, 'initialized'));
            $skippedTotal = array_sum(array_column($results, 'skipped'));

            return redirect()->route('admin.leave-balances.initialize')
                ->with('success', "Initialisation terminée avec succès : {$initializedTotal} soldes initialisés, {$skippedTotal} ignorés.");

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur lors de l\'initialisation des soldes', [
                'error' => $e->getMessage(),
                'year' => $year,
                'department_id' => $departmentId,
                'force' => $force
            ]);

            if ($request->expectsJson() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de l\'initialisation : ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('admin.leave-balances.initialize')
                ->with('error', 'Erreur lors de l\'initialisation : ' . $e->getMessage());
        }
    }

    /**
     * Vérifier la cohérence des soldes
     */
    public function verify(Request $request)
    {
        $year = $request->get('year', now()->year);
        $issues = [];

        // Vérifier les soldes négatifs
        $negativeBalances = LeaveBalance::where('year', $year)
            ->where('current_balance', '<', 0)
            ->with(['user', 'specialLeaveType'])
            ->get();

        foreach ($negativeBalances as $balance) {
            $issues[] = [
                'type' => 'negative_balance',
                'severity' => 'high',
                'user' => $balance->user->first_name . ' ' . $balance->user->last_name,
                'leave_type' => $balance->specialLeaveType->name,
                'balance' => $balance->current_balance,
                'message' => 'Solde négatif détecté'
            ];
        }

        // Vérifier les utilisateurs sans soldes
        $usersWithoutBalances = User::where('is_active', true)
            ->whereDoesntHave('leaveBalances', function($query) use ($year) {
                $query->where('year', $year);
            })
            ->get();

        foreach ($usersWithoutBalances as $user) {
            $issues[] = [
                'type' => 'missing_balances',
                'severity' => 'medium',
                'user' => $user->first_name . ' ' . $user->last_name,
                'message' => 'Aucun solde initialisé pour cette année'
            ];
        }

        // Vérifier les incohérences de calcul
        $balances = LeaveBalance::where('year', $year)->get();
        foreach ($balances as $balance) {
            $expectedCurrent = $balance->initial_balance - $balance->used_balance + $balance->adjustment_balance;
            if ($balance->current_balance != $expectedCurrent) {
                $issues[] = [
                    'type' => 'calculation_error',
                    'severity' => 'high',
                    'user' => $balance->user->first_name . ' ' . $balance->user->last_name,
                    'leave_type' => $balance->specialLeaveType->name,
                    'expected' => $expectedCurrent,
                    'actual' => $balance->current_balance,
                    'message' => 'Erreur de calcul détectée'
                ];
            }
        }

        // JSON pour requêtes AJAX/JSON, sinon redirection avec message
        if ($request->expectsJson() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'issues' => $issues,
                'total_issues' => count($issues)
            ]);
        }

        $issueCount = count($issues);
        $message = $issueCount === 0
            ? "Vérification terminée : aucune anomalie détectée pour l'année {$year}."
            : "Vérification terminée : {$issueCount} anomalie(s) détectée(s) pour l'année {$year}.";

        return redirect()->route('admin.leave-balances.tools')
            ->with('success', $message);
    }

    /**
     * Interface d'ajustement manuel
     */
    public function adjustments(Request $request)
    {
        $userId = $request->get('user_id');
        $year = $request->get('year', now()->year);
        $search = $request->get('search', '');

        $usersQuery = User::where('is_active', true);

        // Appliquer la recherche si fournie
        if (!empty($search)) {
            $usersQuery->where(function($query) use ($search) {
                $query->where('first_name', 'like', '%' . $search . '%')
                      ->orWhere('last_name', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%')
                      ->orWhere('matricule', 'like', '%' . $search . '%');
            });
        }

        $users = $usersQuery->orderBy('first_name')
            ->orderBy('last_name')
            ->get();

        $selectedUser = null;
        $balances = collect();

        if ($userId) {
            $selectedUser = User::find($userId);
            if ($selectedUser) {
                $balances = LeaveBalance::with('specialLeaveType')
                    ->where('user_id', $userId)
                    ->where('year', $year)
                    ->get();
            }
        }

        $leaveTypes = SpecialLeaveType::where('is_active', true)->get();
        $departments = Department::orderBy('name')->get();

        return view('admin.leave-balances.adjustments', compact(
            'users', 'selectedUser', 'balances', 'leaveTypes', 'departments', 'year', 'search'
        ));
    }

    /**
     * Effectuer un ajustement manuel
     */
    public function makeAdjustment(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'special_leave_type_id' => 'required|exists:special_leave_types,id',
            'adjustment_amount' => 'required|integer',
            'reason' => 'required|string|max:500',
            'year' => 'required|integer'
        ]);

        try {
            DB::beginTransaction();

            $user = User::findOrFail($request->user_id);
            $leaveType = SpecialLeaveType::findOrFail($request->special_leave_type_id);
            
            // Obtenir ou créer le solde
            $balance = $this->leaveBalanceService->getOrCreateBalance($user, $leaveType, $request->year);
            
            // Appliquer l'ajustement
            $oldAdjustment = $balance->adjustment_balance;
            $newAdjustment = $oldAdjustment + $request->adjustment_amount;
            
            $balance->update([
                'adjustment_balance' => $newAdjustment,
                'current_balance' => $balance->initial_balance - $balance->used_balance + $newAdjustment,
                'notes' => $balance->notes . "\n" . now()->format('Y-m-d H:i') . " - Ajustement: {$request->adjustment_amount} jours. Raison: {$request->reason}"
            ]);

            // Log de l'ajustement
            Log::info('Ajustement manuel de solde', [
                'admin_user_id' => auth()->id(),
                'target_user_id' => $user->id,
                'leave_type_id' => $leaveType->id,
                'adjustment_amount' => $request->adjustment_amount,
                'reason' => $request->reason,
                'old_adjustment' => $oldAdjustment,
                'new_adjustment' => $newAdjustment
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Ajustement effectué avec succès',
                'new_balance' => $balance->current_balance
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur lors de l\'ajustement manuel', [
                'error' => $e->getMessage(),
                'request' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'ajustement : ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Ajuster un solde individuel depuis le formulaire d'ajustements
     */
    public function adjust(Request $request)
    {
        $request->validate([
            'balance_id' => 'required|exists:leave_balances,id',
            'adjustment_type' => 'required|in:add,subtract,set',
            'amount' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $balance = LeaveBalance::with(['user', 'specialLeaveType'])->findOrFail($request->balance_id);

            $previousCurrent = $balance->current_balance;
            $previousAdjustment = $balance->adjustment_balance;

            // Calculer le delta d'ajustement selon le type
            $delta = 0;
            if ($request->adjustment_type === 'add') {
                $delta = $request->amount;
            } elseif ($request->adjustment_type === 'subtract') {
                $delta = -$request->amount;
            } elseif ($request->adjustment_type === 'set') {
                $targetCurrent = $request->amount;
                $baseWithoutAdjustment = $balance->initial_balance - $balance->used_balance;
                $newAdjustment = $targetCurrent - $baseWithoutAdjustment;
                $delta = $newAdjustment - $previousAdjustment;
            }

            // Appliquer l'ajustement
            $newAdjustmentTotal = $previousAdjustment + $delta;
            $newCurrent = $balance->initial_balance - $balance->used_balance + $newAdjustmentTotal;

            $note = ($balance->notes ? $balance->notes . "\n" : '') .
                now()->format('Y-m-d H:i') .
                " - Ajustement: " . number_format($delta, 2) . " jours" .
                " (type: {$request->adjustment_type}).";

            $balance->update([
                'adjustment_balance' => $newAdjustmentTotal,
                'current_balance' => $newCurrent,
                'notes' => $note,
            ]);

            // Historiser l'ajustement
            LeaveBalanceAdjustment::create([
                'leave_balance_id' => $balance->id,
                'adjusted_by' => auth()->id(),
                'amount' => $delta,
                'reason' => $request->input('reason', 'Ajustement manuel'),
                'previous_balance' => $previousCurrent,
                'new_balance' => $newCurrent,
            ]);

            Log::info('Ajustement individuel de solde', [
                'admin_user_id' => auth()->id(),
                'target_user_id' => $balance->user_id,
                'leave_type_id' => $balance->special_leave_type_id,
                'adjustment_type' => $request->adjustment_type,
                'amount' => $request->amount,
                'delta' => $delta,
                'previous_adjustment' => $previousAdjustment,
                'new_adjustment' => $newAdjustmentTotal,
                'previous_current' => $previousCurrent,
                'new_current' => $newCurrent,
            ]);

            DB::commit();

            return redirect()
                ->route('admin.leave-balances.adjustments', [
                    'user_id' => $balance->user_id,
                    'year' => $balance->year,
                ])
                ->with('success', 'Ajustement effectué avec succès. Nouveau solde: ' . $newCurrent . ' jours');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur lors de l\'ajustement individuel', [
                'error' => $e->getMessage(),
                'request' => $request->all(),
            ]);

            return redirect()
                ->back()
                ->with('error', 'Erreur lors de l\'ajustement: ' . $e->getMessage());
        }
    }

    /**
     * Ajuster en masse les soldes pour un utilisateur et une année
     */
    public function bulkAdjust(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'year' => 'required|integer',
            'adjustment_type' => 'required|in:add,subtract,multiply',
            'amount' => 'required|numeric',
        ]);

        try {
            DB::beginTransaction();

            $balances = LeaveBalance::with(['user', 'specialLeaveType'])
                ->where('user_id', $request->user_id)
                ->where('year', $request->year)
                ->get();

            if ($balances->isEmpty()) {
                return redirect()
                    ->route('admin.leave-balances.adjustments', [
                        'user_id' => $request->user_id,
                        'year' => $request->year,
                    ])
                    ->with('error', 'Aucun solde trouvé pour cet utilisateur et cette année.');
            }

            foreach ($balances as $balance) {
                $previousCurrent = $balance->current_balance;
                $previousAdjustment = $balance->adjustment_balance;

                $delta = 0;
                if ($request->adjustment_type === 'add') {
                    $delta = $request->amount;
                } elseif ($request->adjustment_type === 'subtract') {
                    $delta = -$request->amount;
                } elseif ($request->adjustment_type === 'multiply') {
                    $targetCurrent = $previousCurrent * $request->amount;
                    $baseWithoutAdjustment = $balance->initial_balance - $balance->used_balance;
                    $newAdjustment = $targetCurrent - $baseWithoutAdjustment;
                    $delta = $newAdjustment - $previousAdjustment;
                }

                $newAdjustmentTotal = $previousAdjustment + $delta;
                $newCurrent = $balance->initial_balance - $balance->used_balance + $newAdjustmentTotal;

                $note = ($balance->notes ? $balance->notes . "\n" : '') .
                    now()->format('Y-m-d H:i') .
                    " - Ajustement en lot: " . number_format($delta, 2) . " jours" .
                    " (type: {$request->adjustment_type}).";

                $balance->update([
                    'adjustment_balance' => $newAdjustmentTotal,
                    'current_balance' => $newCurrent,
                    'notes' => $note,
                ]);

                LeaveBalanceAdjustment::create([
                    'leave_balance_id' => $balance->id,
                    'adjusted_by' => auth()->id(),
                    'amount' => $delta,
                    'reason' => $request->input('reason', 'Ajustement en lot'),
                    'previous_balance' => $previousCurrent,
                    'new_balance' => $newCurrent,
                ]);
            }

            DB::commit();

            return redirect()
                ->route('admin.leave-balances.adjustments', [
                    'user_id' => $request->user_id,
                    'year' => $request->year,
                ])
                ->with('success', 'Ajustement en lot effectué avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur lors de l\'ajustement en lot', [
                'error' => $e->getMessage(),
                'request' => $request->all(),
            ]);

            return redirect()
                ->back()
                ->with('error', 'Erreur lors de l\'ajustement en lot: ' . $e->getMessage());
        }
    }

    /**
     * Ajustement global d'un solde pour un type de congé
     * - Cible: tous les utilisateurs actifs d'un département donné (ou tous)
     * - Opération: add | subtract | set sur le solde courant via adjustment_balance
     */
    public function globalAdjust(Request $request)
    {
        $request->validate([
            'special_leave_type_id' => 'required|exists:special_leave_types,id',
            'year' => 'required|integer',
            'department_id' => 'nullable|exists:departments,id',
            'scope' => 'required|in:department,all',
            'adjustment_type' => 'required|in:add,subtract,set',
            'amount' => 'required|numeric',
            'reason' => 'nullable|string|max:500',
        ]);

        try {
            DB::beginTransaction();

            $leaveType = SpecialLeaveType::findOrFail($request->special_leave_type_id);

            $usersQuery = User::where('is_active', true);
            if ($request->scope === 'department' && $request->filled('department_id')) {
                $usersQuery->where('department_id', $request->department_id);
            }

            $users = $usersQuery->get();

            $processed = 0;
            foreach ($users as $user) {
                // Obtenir ou créer le solde
                $balance = $this->leaveBalanceService->getOrCreateBalance($user, $leaveType, $request->year);

                $previousCurrent = $balance->current_balance;
                $previousAdjustment = $balance->adjustment_balance;

                $delta = 0;
                if ($request->adjustment_type === 'add') {
                    $delta = $request->amount;
                } elseif ($request->adjustment_type === 'subtract') {
                    $delta = -$request->amount;
                } elseif ($request->adjustment_type === 'set') {
                    $targetCurrent = $request->amount;
                    $baseWithoutAdjustment = $balance->initial_balance - $balance->used_balance;
                    $newAdjustment = $targetCurrent - $baseWithoutAdjustment;
                    $delta = $newAdjustment - $previousAdjustment;
                }

                $newAdjustmentTotal = $previousAdjustment + $delta;
                $newCurrent = $balance->initial_balance - $balance->used_balance + $newAdjustmentTotal;

                $note = ($balance->notes ? $balance->notes . "\n" : '') .
                    now()->format('Y-m-d H:i') .
                    " - Ajustement global: " . number_format($delta, 2) . " jours" .
                    " (type: {$request->adjustment_type})." .
                    ($request->reason ? " Raison: {$request->reason}" : '');

                $balance->update([
                    'adjustment_balance' => $newAdjustmentTotal,
                    'current_balance' => $newCurrent,
                    'notes' => $note,
                ]);

                LeaveBalanceAdjustment::create([
                    'leave_balance_id' => $balance->id,
                    'adjusted_by' => auth()->id(),
                    'amount' => $delta,
                    'reason' => $request->input('reason', 'Ajustement global'),
                    'previous_balance' => $previousCurrent,
                    'new_balance' => $newCurrent,
                ]);

                $processed++;
            }

            DB::commit();

            return redirect()
                ->route('admin.leave-balances.adjustments', ['year' => $request->year])
                ->with('success', "Ajustement global effectué: {$processed} utilisateurs mis à jour.");

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Erreur lors de l'ajustement global", [
                'error' => $e->getMessage(),
                'request' => $request->all(),
            ]);

            return redirect()
                ->back()
                ->with('error', 'Erreur lors de l\'ajustement global: ' . $e->getMessage());
        }
    }

    /**
     * Afficher le formulaire d'initialisation des soldes
     */
    public function initialize()
    {
        $currentYear = date('Y');
        $years = range($currentYear - 2, $currentYear + 1);
        
        // Récupérer les départements pour le filtrage
        $departments = Department::orderBy('name')->get();
        
        return view('admin.leave-balances.initialize', compact('years', 'departments', 'currentYear'));
    }

    /**
     * Obtenir les statistiques générales
     */
    private function getGeneralStats($year)
    {
        return [
            'total_users' => User::where('is_active', true)->count(),
            'users_with_balances' => User::whereHas('leaveBalances', function($query) use ($year) {
                $query->where('year', $year);
            })->count(),
            'total_initial_days' => LeaveBalance::where('year', $year)->sum('initial_balance'),
            'total_used_days' => LeaveBalance::where('year', $year)->sum('used_balance'),
            'total_current_days' => LeaveBalance::where('year', $year)->sum('current_balance'),
            'negative_balances' => LeaveBalance::where('year', $year)->where('current_balance', '<', 0)->count(),
        ];
    }

    /**
     * Exporter les soldes de congés au format Excel
     */
    public function export(Request $request)
    {
        $validated = $request->validate([
            'year' => 'required|integer|min:2000|max:2100',
            'department_id' => 'nullable|exists:departments,id',
        ]);

        $year = (int) $validated['year'];
        $departmentId = $validated['department_id'] ?? null;

        $query = LeaveBalance::with(['user.department', 'specialLeaveType'])
            ->where('year', $year);

        if ($departmentId) {
            $query->whereHas('user', function ($q) use ($departmentId) {
                $q->where('department_id', $departmentId);
            });
        }

        $balances = $query->get();

        if ($balances->isEmpty()) {
            return back()->with('error', "Aucun solde trouvé pour l'année {$year}" . ($departmentId ? ' dans le département sélectionné.' : '.'));
        }

        $departmentSlug = '';
        if ($departmentId) {
            $department = Department::find($departmentId);
            if ($department) {
                $departmentSlug = '_' . Str::slug($department->name);
            }
        }

        $filename = "soldes_conges_{$year}{$departmentSlug}.xlsx";

        return Excel::download(new LeaveBalancesExport($balances), $filename, \Maatwebsite\Excel\Excel::XLSX);
    }
}