<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('departments')->ignore($department->id)],
            'code' => ['required', 'string', 'max:10', Rule::unique('departments')->ignore($department->id)],
            'description' => 'nullable|string|max:1000',
            'head_id' => 'nullable|exists:users,id'
        ]);

        // Si le chef de département change
        if ($request->filled('head_id')) {
            // Retirer l'ancien chef s'il existe
            User::where('department_id', $department->id)
                ->where('role', User::ROLE_DEPARTMENT_HEAD)
                ->update(['department_id' => null]);

            // Assigner le nouveau chef
            User::where('id', $request->head_id)
                ->update(['department_id' => $department->id]);
        } else {
            // Si aucun chef n'est sélectionné, retirer l'ancien chef
            User::where('department_id', $department->id)
                ->where('role', User::ROLE_DEPARTMENT_HEAD)
                ->update(['department_id' => null]);
        }

        $department->update($validatedData);

        return redirect()->route('admin.departments.index')
            ->with('success', 'Département mis à jour avec succès');
    }

    public function show(Department $department)
    {
        $department->load(['teams.manager', 'teams.members']);
        return view('admin.departments.show', compact('department'));
    }

    public function destroy(Department $department)
    {
        if ($department->employees()->exists()) {
            return back()->withErrors(['error' => 'Impossible de supprimer ce département car il contient des employés']);
        }

        $department->delete();

        return redirect()->route('admin.departments.index')
            ->with('success', 'Département supprimé avec succès');
    }
}
