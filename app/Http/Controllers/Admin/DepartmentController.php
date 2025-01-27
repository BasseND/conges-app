<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;


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

        return view('admin.departments.create', compact('departmentHeads'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:departments',
            'code' => 'required|string|max:10|unique:departments',
            'description' => 'nullable|string|max:1000',
            'head_id' => 'nullable|exists:users,id'
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

        return view('admin.departments.edit', compact('department', 'departmentHeads'));
    }

    public function update(Request $request, Department $department)
    {
        $this->authorize('manage-departments');

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:departments,name,' . $department->id,
            'description' => 'nullable|string|max:1000',
            'head_id' => 'nullable|exists:users,id'
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
            ->orderBy('name')
            ->get();

        $users = $department->users()
            ->orderBy('name')
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
}
