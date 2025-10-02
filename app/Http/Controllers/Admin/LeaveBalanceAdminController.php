<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\LeaveBalance;
use App\Models\SpecialLeaveType;
use App\Models\Department;
use App\Models\LeaveBalanceAdjustment;
use App\Services\LeaveBalanceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

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
     * Initialiser les soldes pour tous les utilisateurs
     */
    public function initializeAll(Request $request)
    {
        $request->validate([
            'year' => 'required|integer|min:2020|max:2030',
            'force' => 'boolean'
        ]);

        $year = $request->year;
        $force = $request->boolean('force');
        $results = [];

        try {
            DB::beginTransaction();

            $users = User::where('is_active', true)->get();
            
            foreach ($users as $user) {
                $result = $this->leaveBalanceService->initializeUserBalances($user, $year, $force);
                $results[] = [
                    'user' => $user->first_name . ' ' . $user->last_name,
                    'initialized' => $result['initialized'],
                    'skipped' => $result['skipped']
                ];
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Initialisation terminée avec succès',
                'results' => $results
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erreur lors de l\'initialisation des soldes', [
                'error' => $e->getMessage(),
                'year' => $year
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'initialisation : ' . $e->getMessage()
            ], 500);
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

        return response()->json([
            'success' => true,
            'issues' => $issues,
            'total_issues' => count($issues)
        ]);
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

        return view('admin.leave-balances.adjustments', compact(
            'users', 'selectedUser', 'balances', 'leaveTypes', 'year', 'search'
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
}