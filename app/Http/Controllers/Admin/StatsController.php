<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Leave;
use App\Models\User;
use App\Models\ExpenseReport;
use App\Models\Contract;
use App\Models\SalaryAdvance;
use App\Models\AttestationRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin,hr_admin,hr']);
    }

    public function index()
    {
        // Statistiques par département
        $departmentStats = Department::select('departments.name')
            ->selectRaw('COALESCE(SUM(DATEDIFF(leaves.end_date, leaves.start_date) + 1), 0) as total_days')
            ->leftJoin('users', 'departments.id', '=', 'users.department_id')
            ->leftJoin('leaves', function($join) {
                $join->on('users.id', '=', 'leaves.user_id')
                    ->where('leaves.status', '=', 'approved');
            })
            ->groupBy('departments.id', 'departments.name')
            ->get();

        // Statistiques par mois
        $monthlyStats = Leave::select(
                DB::raw('DATE_FORMAT(start_date, "%Y-%m") as month'),
                DB::raw('SUM(DATEDIFF(end_date, start_date) + 1) as total_days')
            )
            ->where('status', 'approved')
            ->where('start_date', '>=', Carbon::now()->subMonths(12))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->map(function ($item) {
                $date = Carbon::createFromFormat('Y-m', $item->month);
                $item->month = $date->format('F Y');
                return $item;
            });

        // Statistiques mensuelles des notes de frais
        $expenseStats = ExpenseReport::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('SUM(total_amount) as total_amount')
            )
            ->where('status', '!=', ExpenseReport::STATUS_DRAFT)
            ->where('created_at', '>=', Carbon::now()->subMonths(12))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->map(function ($item) {
                $date = Carbon::createFromFormat('Y-m', $item->month);
                $item->month = $date->format('M');
                return $item;
            });

        // Créer un tableau complet pour les 12 derniers mois
        $expenseMonthlyStats = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthKey = $month->format('Y-m');
            $monthLabel = $month->format('M');
            
            $found = $expenseStats->firstWhere('month', $monthLabel);
            $expenseMonthlyStats[] = [
                'month' => $monthLabel,
                'total' => $found ? (float) $found->total_amount : 0
            ];
        }

        // Statistiques mensuelles des accomptes
        $salaryAdvanceStats = SalaryAdvance::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('SUM(amount) as total_amount')
            )
            ->where('status', '!=', SalaryAdvance::STATUS_PENDING)
            ->where('created_at', '>=', Carbon::now()->subMonths(12))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->map(function ($item) {
                $date = Carbon::createFromFormat('Y-m', $item->month);
                $item->month = $date->format('M');
                return $item;
            });

        // Créer un tableau complet pour les 12 derniers mois des accomptes
        $salaryAdvanceMonthlyStats = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthKey = $month->format('Y-m');
            $monthLabel = $month->format('M');
            
            $found = $salaryAdvanceStats->firstWhere('month', $monthLabel);
            $salaryAdvanceMonthlyStats[] = [
                'month' => $monthLabel,
                'total' => $found ? (float) $found->total_amount : 0
            ];
        }

        // Statistiques des contrats par type
        $contractStats = Contract::select('type')
            ->selectRaw('COUNT(*) as count')
            ->selectRaw('SUM(salaire_brut) as total_amount')
            ->where('statut', 'actif')
            ->where('is_expired', false)
            ->groupBy('type')
            ->get()
            ->map(function ($item) {
                return [
                    'type' => $item->type,
                    'label' => Contract::getContractTypes()[$item->type] ?? $item->type,
                    'count' => $item->count,
                    'total_amount' => (float) $item->total_amount
                ];
            });

        // Statistiques générales
        $stats = [
            'pending' => Leave::where('status', 'pending')->count(),
            'approved' => Leave::where('status', 'approved')->count(),
            'rejected' => Leave::where('status', 'rejected')->count(),
            'pending_expenses' => ExpenseReport::where('status', ExpenseReport::STATUS_SUBMITTED)->count(),
            'employees' => User::where('role', 'employee')->count(),
            'managers' => User::where('role', 'manager')->count(),
            'admins' => User::where('role', 'admin')->count(),
            'hr_users' => User::where('role', 'hr')->count(),
            'department_heads' => Department::whereNotNull('head_id')->count(),
            'active_employees' => User::where('is_active', true)
                                      ->where('is_prestataire', false)
                                      ->count(),
            'prestataires' => User::where('is_prestataire', true)->count(),
            'total_users' => User::count(),
            'total_leaves' => Leave::count(),
            'total_days' => Leave::selectRaw('COALESCE(SUM(DATEDIFF(end_date, start_date) + 1), 0) as total_days')
                                 ->where('status', 'approved')
                                 ->first()
                                 ->total_days,
            'total_months_expenses' => ExpenseReport::where('status', ExpenseReport::STATUS_APPROVED)
                                 ->orWhere('status', ExpenseReport::STATUS_PAID)
                                 ->sum('total_amount'),
            'total_salary_mass' => Contract::where('is_expired', false)
                      ->where('type', '!=', Contract::CONTRACT_FREELANCE)
                      ->where('statut', 'actif')
                      ->sum('salaire_brut'),
            'temporary_contracts' => Contract::where('statut', 'actif')
                      ->whereNotNull('date_fin')
                      ->where('date_fin', '>', Carbon::now())
                      ->where('date_fin', '<=', Carbon::now()->addDays(60))
                      ->count(),
            // Statistiques des demandes d'accompte
            'salary_advances_pending' => SalaryAdvance::where('status', SalaryAdvance::STATUS_PENDING)->count(),
            'salary_advances_submitted' => SalaryAdvance::where('status', SalaryAdvance::STATUS_SUBMITTED)->count(),
            'salary_advances_approved' => SalaryAdvance::where('status', SalaryAdvance::STATUS_APPROVED)->count(),
            'salary_advances_total' => SalaryAdvance::count(),
            'salary_advances_amount_pending' => SalaryAdvance::where('status', SalaryAdvance::STATUS_PENDING)
                                                            ->orWhere('status', SalaryAdvance::STATUS_SUBMITTED)
                                                            ->sum('amount'),
            'salary_advances_amount_approved' => SalaryAdvance::where('status', SalaryAdvance::STATUS_APPROVED)
                                                              ->sum('amount'),
            // Statistiques des demandes d'attestations
            'attestations_pending' => AttestationRequest::where('status', AttestationRequest::STATUS_PENDING)
                                                        ->where('category', 'employee_request')
                                                        ->count()
        ];

        // Dernières notes de frais
        $recentExpenses = ExpenseReport::with('user')
            ->latest()
            ->take(5)
            ->get();

        // Dernières activités
        $recentLeaves = Leave::with('user')
            ->latest()
            ->take(5)
            ->get();

        // Dernières demandes d'accompte
        $recentSalaryAdvances = SalaryAdvance::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.stats', compact(
            'departmentStats',
            'monthlyStats',
            'expenseMonthlyStats',
            'salaryAdvanceMonthlyStats',
            'contractStats',
            'stats',
            'recentLeaves',
            'recentExpenses',
            'recentSalaryAdvances'
        ));
    }
}
