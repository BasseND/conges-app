<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SalaryAdvance;
use App\Models\User;
use App\Models\Department;
use App\Events\SalaryAdvanceStatusUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalaryAdvanceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin,hr']);
    }

    /**
     * Affiche la liste des demandes d'avances sur salaire pour l'administrateur
     */
    public function index(Request $request)
    {
        // Pagination flexible
        $perPage = $request->get('per_page', 50);
        $perPage = in_array($perPage, [25, 50, 100]) ? $perPage : 50;

        // Eager loading sélectif avec colonnes spécifiques
        $query = SalaryAdvance::with([
            'user:id,first_name,last_name,email,employee_id,department_id',
            'user.department:id,name',
            'approver:id,first_name,last_name'
        ]);

        // Recherche par nom d'employé
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('employee_id', 'like', "%{$search}%");
            });
        }

        // Filtre par département
        if ($request->filled('department')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('department_id', $request->department);
            });
        }

        // Filtre par statut
        if ($request->filled('status') && array_key_exists($request->status, SalaryAdvance::getStatuses())) {
            $query->where('status', $request->status);
        }

        // Filtre par date
        if ($request->filled('date_from')) {
            $query->where('request_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('request_date', '<=', $request->date_to);
        }

        $salaryAdvances = $query->latest('request_date')->paginate($perPage);

        // Conserver les paramètres de filtrage dans les liens de pagination
        $salaryAdvances->appends($request->only(['search', 'department', 'status', 'date_from', 'date_to', 'per_page']));

        // Optimiser la récupération des départements
        $departments = Department::select('id', 'name')->orderBy('name')->get();

        // Calculer les statistiques de manière optimisée
        $stats = [
            'total' => SalaryAdvance::count(),
            'pending' => SalaryAdvance::where('status', SalaryAdvance::STATUS_PENDING)->count(),
            'submitted' => SalaryAdvance::where('status', SalaryAdvance::STATUS_SUBMITTED)->count(),
            'approved' => SalaryAdvance::where('status', SalaryAdvance::STATUS_APPROVED)->count(),
        ];

        return view('admin.salary-advances.index', compact('salaryAdvances', 'departments', 'stats'));
    }

    /**
     * Affiche les détails d'une demande d'avance sur salaire
     */
    public function show(SalaryAdvance $salaryAdvance)
    {
        $salaryAdvance->load(['user', 'user.department', 'approver', 'repayments']);
        
        $repayments = $salaryAdvance->repayments;
        
        return view('salary-advances.show', compact('salaryAdvance', 'repayments'));
    }

    /**
     * Approuve une demande d'avance sur salaire
     */
    public function approve(SalaryAdvance $salaryAdvance)
    {
        // Vérifier que la demande peut être approuvée
        if (!in_array($salaryAdvance->status, [SalaryAdvance::STATUS_PENDING, SalaryAdvance::STATUS_SUBMITTED])) {
            return back()->with('error', 'Cette demande ne peut pas être approuvée dans son état actuel.');
        }

        try {
            $previousStatus = $salaryAdvance->status;
            $salaryAdvance->update([
                'status' => SalaryAdvance::STATUS_APPROVED,
                'approval_date' => now(),
                'approved_by' => Auth::id(),
            ]);

            // Déclencher l'événement pour notifier l'auteur de la demande
            event(new SalaryAdvanceStatusUpdated($salaryAdvance, $previousStatus));

            return back()->with('success', 'La demande d\'avance sur salaire a été approuvée avec succès.');
        } catch (\Exception $e) {
            \Log::error('Erreur lors de l\'approbation de la demande d\'avance sur salaire: ' . $e->getMessage(), [
                'salary_advance_id' => $salaryAdvance->id,
                'user_id' => Auth::id(),
                'exception' => $e
            ]);
            return back()->with('error', 'Une erreur est survenue lors de l\'approbation de la demande: ' . $e->getMessage());
        }
    }

    /**
     * Rejette une demande d'avance sur salaire
     */
    public function reject(Request $request, SalaryAdvance $salaryAdvance)
    {
        // Vérifier que la demande peut être rejetée
        if (!in_array($salaryAdvance->status, [SalaryAdvance::STATUS_PENDING, SalaryAdvance::STATUS_SUBMITTED])) {
            return back()->with('error', 'Cette demande ne peut pas être rejetée dans son état actuel.');
        }

        $request->validate([
            'notes' => 'nullable|string|max:1000',
        ]);

        try {
            $previousStatus = $salaryAdvance->status;
            $salaryAdvance->update([
                'status' => SalaryAdvance::STATUS_REJECTED,
                'notes' => $request->notes,
                'approved_by' => Auth::id(),
                'approval_date' => now(),
            ]);

            // Déclencher l'événement pour notifier l'auteur de la demande
            event(new SalaryAdvanceStatusUpdated($salaryAdvance, $previousStatus));

            return back()->with('success', 'La demande d\'avance sur salaire a été rejetée.');
        } catch (\Exception $e) {
            \Log::error('Erreur lors du rejet de la demande d\'avance sur salaire: ' . $e->getMessage(), [
                'salary_advance_id' => $salaryAdvance->id,
                'user_id' => Auth::id(),
                'exception' => $e
            ]);
            return back()->with('error', 'Une erreur est survenue lors du rejet de la demande: ' . $e->getMessage());
        }
    }

    /**
     * Retourne les statistiques des avances sur salaire au format JSON
     */
    public function getStats(Request $request)
    {
        $query = SalaryAdvance::query();

        // Appliquer les filtres de date si fournis
        if ($request->filled('date_from')) {
            $query->where('request_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('request_date', '<=', $request->date_to);
        }

        $stats = [
            'total_requests' => $query->count(),
            'total_amount' => $query->sum('amount'),
            'approved_amount' => $query->where('status', SalaryAdvance::STATUS_APPROVED)->sum('amount'),
            'pending_amount' => $query->where('status', SalaryAdvance::STATUS_PENDING)->sum('amount'),
            'submitted_amount' => $query->where('status', SalaryAdvance::STATUS_SUBMITTED)->sum('amount'),
            'by_status' => [
                'pending' => $query->where('status', SalaryAdvance::STATUS_PENDING)->count(),
                'submitted' => $query->where('status', SalaryAdvance::STATUS_SUBMITTED)->count(),
                'approved' => $query->where('status', SalaryAdvance::STATUS_APPROVED)->count(),
                'rejected' => $query->where('status', SalaryAdvance::STATUS_REJECTED)->count(),
                'cancelled' => $query->where('status', SalaryAdvance::STATUS_CANCELLED)->count(),
            ],
            'by_department' => Department::withCount([
                'users as salary_advances_count' => function ($query) use ($request) {
                    $query->join('salary_advances', 'users.id', '=', 'salary_advances.user_id');
                    if ($request->filled('date_from')) {
                        $query->where('salary_advances.request_date', '>=', $request->date_from);
                    }
                    if ($request->filled('date_to')) {
                        $query->where('salary_advances.request_date', '<=', $request->date_to);
                    }
                }
            ])->get()->pluck('salary_advances_count', 'name'),
        ];

        return response()->json($stats);
    }

    /**
     * Exporte les données des avances sur salaire
     */
    public function export(Request $request)
    {
        $query = SalaryAdvance::with(['user', 'user.department', 'approver']);

        // Appliquer les mêmes filtres que dans la méthode index
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('employee_id', 'like', "%{$search}%");
            });
        }

        if ($request->filled('department')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('department_id', $request->department);
            });
        }

        if ($request->filled('status') && array_key_exists($request->status, SalaryAdvance::getStatuses())) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->where('request_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('request_date', '<=', $request->date_to);
        }

        $salaryAdvances = $query->latest('request_date')->get();

        // Ici vous pourriez implémenter l'export Excel/CSV
        // Pour l'instant, on retourne juste un message
        return back()->with('success', 'Export en cours de développement.');
    }
}