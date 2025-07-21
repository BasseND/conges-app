<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\User;
use App\Models\LeaveBalance;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DepartmentsImport;
use App\Exports\DepartmentsTemplateExport;


class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::with('manager')->get();
        return view('admin.departments.index', compact('departments'));
    }

    public function create()
    {
        $departmentHeads = User::where('role', User::ROLE_DEPARTMENT_HEAD)
            ->whereDoesntHave('department', function($query) {
                $query->where('role', User::ROLE_DEPARTMENT_HEAD);
            })
            ->get();

        // Récupérer les soldes de congés de l'entreprise
        $leaveBalances = LeaveBalance::where('company_id', auth()->user()->company_id)
            ->orderBy('is_default', 'desc')
            ->orderBy('description')
            ->get();

        return view('admin.departments.create', compact('departmentHeads', 'leaveBalances'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:departments',
            'code' => 'required|string|max:10|unique:departments',
            'description' => 'nullable|string|max:1000',
            'head_id' => 'nullable|exists:users,id',
            'leave_balance_id' => 'nullable|exists:leave_balances,id'
        ]);

        $department = Department::create($validatedData);

        // Si un chef de département est sélectionné, mettre à jour son département
        if ($request->filled('head_id')) {
            User::where('id', $request->head_id)
                ->update(['department_id' => $department->id]);
        }

        return redirect()->route('admin.departments.index')
            ->with('success', 'Département créé avec succès.');
    }

    public function edit(Department $department)
    {
        // Récupérer les chefs de département disponibles (non assignés ou déjà assigné à ce département)
        $departmentHeads = User::where('role', User::ROLE_DEPARTMENT_HEAD)
            ->where(function($query) use ($department) {
                $query->whereNull('department_id')
                    ->orWhere('department_id', $department->id);
            })
            ->get();

        // Récupérer les soldes de congés de l'entreprise
        $leaveBalances = LeaveBalance::where('company_id', $department->company_id)
            ->orderBy('is_default', 'desc')
            ->orderBy('description')
            ->get();

        return view('admin.departments.edit', compact('department', 'departmentHeads', 'leaveBalances'));
    }

    public function update(Request $request, Department $department)
    {
        $this->authorize('manage-departments');

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:departments,name,' . $department->id,
            'description' => 'nullable|string|max:1000',
            'head_id' => 'nullable|exists:users,id',
            'leave_balance_id' => 'nullable|exists:leave_balances,id'
        ]);

        try {
            $department->update($validated);
            return redirect()->route('admin.departments.show', $department)
                ->with('success', 'Département mis à jour avec succès.');
        } catch (\Exception $e) {
            return back()->with('error', 'Une erreur est survenue lors de la mise à jour du département.');
        }
    }

    public function show(Department $department)
    {
        $department->load(['teams.manager', 'teams.members']);
        
        // Debug logging
        foreach ($department->teams as $team) {
            \Log::info("Team {$team->name} members count: " . $team->members->count());
            \Log::info("Team {$team->name} members: " . $team->members->pluck('name')->join(', '));
        }
        
        $managers = $department->users()
            ->where('role', 'manager')
            ->orderBy('first_name')
            ->get();

        $users = $department->users()
            ->orderBy('first_name')
            ->get();

        return view('admin.departments.show', [
            'department' => $department,
            'managers' => $managers,
            'users' => $users
        ]);
    }


    public function destroy(Department $department)
    {
        $this->authorize('manage-departments');

        try {
            // Vérifier si le département a des employés
            if ($department->users()->count() > 0) {
                return back()->with('error', 'Impossible de supprimer un département qui contient des employés.');
            }

            $department->delete();
            return redirect()->route('admin.departments.index')
                ->with('success', 'Département supprimé avec succès.');
        } catch (\Exception $e) {
            return back()->with('error', 'Une erreur est survenue lors de la suppression du département.');
        }
    }

    /**
     * Affiche la page d'import en masse
     */
    public function showImport()
    {
        return view('admin.departments.import');
    }

    /**
     * Traite l'import en masse de départements
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048'
        ], [
            'file.required' => 'Veuillez sélectionner un fichier.',
            'file.mimes' => 'Le fichier doit être au format Excel (.xlsx, .xls) ou CSV.',
            'file.max' => 'Le fichier ne doit pas dépasser 2 Mo.'
        ]);

        try {
            $import = new DepartmentsImport();
            Excel::import($import, $request->file('file'));

            $successCount = $import->getSuccessCount();
            $errorCount = $import->getErrorCount();
            $errors = $import->getErrors();

            if ($errorCount > 0) {
                return redirect()->route('admin.departments.import')
                    ->with('warning', "Import terminé avec {$successCount} départements créés et {$errorCount} erreurs.")
                    ->with('import_errors', $errors);
            }

            return redirect()->route('admin.departments.index')
                ->with('success', "{$successCount} départements ont été importés avec succès.");

        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'import de départements: ' . $e->getMessage());
            return redirect()->route('admin.departments.import')
                ->with('error', 'Erreur lors de l\'import: ' . $e->getMessage());
        }
    }

    /**
     * Télécharge le modèle Excel pour l'import
     */
    public function downloadTemplate()
    {
        $headers = [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="modele_import_departements.xlsx"'
        ];

        return Excel::download(new DepartmentsTemplateExport(), 'modele_import_departements.xlsx', \Maatwebsite\Excel\Excel::XLSX, $headers);
    }
}
