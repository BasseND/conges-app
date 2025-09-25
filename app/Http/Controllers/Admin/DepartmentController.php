<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Department;
use App\Models\User;
// use App\Models\LeaveBalance; // Supprimé - remplacé par SpecialLeaveType
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
        $this->authorize('manage-departments');
        
        // Récupérer les chefs de département disponibles (non assignés)
        $departmentHeads = User::where('role', User::ROLE_DEPARTMENT_HEAD)
            ->whereDoesntHave('departmentAsHead') // Utiliser la relation pour vérifier qu'ils ne sont pas déjà chef d'un département
            ->get();
            
        return view('admin.departments.create', compact('departmentHeads'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:departments',
            'code' => 'required|string|max:10|unique:departments',
            'description' => 'nullable|string|max:1000',
            'head_id' => 'nullable|exists:users,id',
        ]);

        // Récupérer l'entreprise de manière robuste
        $company = Company::first();
        if (!$company) {
            return redirect()->back()
                ->withErrors(['company_id' => 'Aucune entreprise n\'est configurée dans le système.'])
                ->withInput();
        }
        $validatedData['company_id'] = $company->id;

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
                    ->orWhere('department_id', $department->id)
                    ->orWhere('id', $department->head_id); // Inclure le chef actuel même s'il est assigné
            })
            ->get();

        // LeaveBalances supprimé - remplacé par SpecialLeaveType
        // $leaveBalances = LeaveBalance::where('company_id', $department->company_id)
        //     ->orderBy('is_default', 'desc')
        //     ->orderBy('description')
        //     ->get();

        return view('admin.departments.edit', compact('department', 'departmentHeads'));
    }

    public function update(Request $request, Department $department)
    {
        $this->authorize('manage-departments');

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:departments,name,' . $department->id,
            'code' => 'required|string|max:10|unique:departments,code,' . $department->id,
            'description' => 'nullable|string|max:1000',
            'head_id' => 'nullable|exists:users,id',
        ]);
       
        try {
            // Récupérer l'ancien chef de département
            $oldHeadId = $department->head_id;
            
            // Mettre à jour le département
            $department->update($validated);
            
            // Gérer les changements de chef de département
            if ($oldHeadId != $request->head_id) {
                // Retirer l'ancien chef du département s'il existe
                if ($oldHeadId) {
                    User::where('id', $oldHeadId)
                        ->update(['department_id' => null]);
                }
                
                // Assigner le nouveau chef au département s'il est sélectionné
                if ($request->filled('head_id')) {
                    User::where('id', $request->head_id)
                        ->update(['department_id' => $department->id]);
                }
            }
            
            return redirect()->route('admin.departments.index')
                ->with('success', 'Département mis à jour avec succès.');
        } catch (\Exception $e) {
            return back()->with('error', 'Une erreur est survenue lors de la mise à jour du département.');
        }
    }

    public function show(Department $department)
    {
        $department->load(['teams.manager', 'teams.members']);
        
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

    /**
     * Affiche l'organigramme du département
     */
    public function organigramme(Department $department)
    {
        // Accessible à tous les utilisateurs authentifiés

        // Charger toutes les relations nécessaires pour l'organigramme
        $department->load([
            'head',
            'teams.manager',
            'teams.members' => function ($query) {
                $query->where('is_active', true);
            },
            'users' => function ($query) {
                $query->where('is_active', true);
            }
        ]);

        // Préparer les données pour l'organigramme
        $organigrammeData = [
            'department' => [
                'id' => $department->id,
                'name' => $department->name,
                'head' => $department->head ? [
                    'id' => $department->head->id,
                    'name' => $department->head->first_name . ' ' . $department->head->last_name,
                    'position' => $department->head->position ?? 'Chef de département',
                    'email' => $department->head->email,
                    'avatar' => $department->head->avatar ?? null
                ] : null
            ],
            'teams' => $department->teams->map(function ($team) {
                return [
                    'id' => $team->id,
                    'name' => $team->name,
                    'manager' => $team->manager ? [
                        'id' => $team->manager->id,
                        'name' => $team->manager->first_name . ' ' . $team->manager->last_name,
                        'position' => $team->manager->position ?? 'Manager',
                        'email' => $team->manager->email,
                        'avatar' => $team->manager->avatar ?? null
                    ] : null,
                    'members' => $team->members->map(function ($member) {
                        return [
                            'id' => $member->id,
                            'name' => $member->first_name . ' ' . $member->last_name,
                            'position' => $member->position ?? 'Employé',
                            'email' => $member->email,
                            'avatar' => $member->avatar ?? null
                        ];
                    })
                ];
            }),
            'unassignedUsers' => $department->users->filter(function ($user) use ($department) {
                // Utilisateurs qui ne sont ni chef de département ni dans une équipe
                $isHead = $department->head_id === $user->id;
                $isInTeam = $department->teams->flatMap->members->contains('id', $user->id);
                $isManager = $department->teams->contains('manager_id', $user->id);
                
                return !$isHead && !$isInTeam && !$isManager;
            })->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->first_name . ' ' . $user->last_name,
                    'position' => $user->position ?? 'Employé',
                    'email' => $user->email,
                    'avatar' => $user->avatar ?? null
                ];
            })->values()
        ];

        return view('admin.departments.organigramme', compact('department', 'organigrammeData'));
    }
}
