<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Department;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query()->with('department');

        // Recherche par nom ou email
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('email', 'like', "%{$searchTerm}%");
            });
        }

        // Filtre par rôle
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filtre par département
        if ($request->filled('department')) {
            $query->where('department_id', $request->department);
        }

        // Tri
        $sortField = $request->input('sort', 'name');
        $sortDirection = $request->input('direction', 'asc');
        $query->orderBy($sortField, $sortDirection);

        $users = $query->paginate(10)->withQueryString();
        $departments = Department::all();

        return view('admin.users.index', compact('users', 'departments'));
    }

    public function create()
    {
        $departments = Department::all();
        $teams = Team::all();
        return view('admin.users.create', compact('departments', 'teams'));
    }

    public function store(Request $request)
    {
        Log::info('Request data:', $request->all());

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => ['required', Rule::in([
                User::ROLE_EMPLOYEE,
                User::ROLE_MANAGER,
                User::ROLE_ADMIN,
                User::ROLE_HR,
                User::ROLE_DEPARTMENT_HEAD
            ])],
            'department_id' => 'required|exists:departments,id',
            'team_id' => 'nullable|exists:teams,id',
            'annual_leave_days' => 'required|integer|min:0',
            'sick_leave_days' => 'required|integer|min:0',
        ]);

        Log::info('Validated data:', $validatedData);
        
        // Get team_id and remove it from validatedData
        $teamId = $request->filled('team_id') ? $validatedData['team_id'] : null;
        unset($validatedData['team_id']);

        // Vérifier s'il existe déjà un chef pour ce département
        if ($validatedData['role'] === User::ROLE_DEPARTMENT_HEAD) {
            $existingHead = User::where('department_id', $validatedData['department_id'])
                ->where('role', User::ROLE_DEPARTMENT_HEAD)
                ->exists();

            if ($existingHead) {
                return back()
                    ->withInput()
                    ->withErrors(['role' => 'Ce département a déjà un chef.']);
            }
        }

        $validatedData['password'] = Hash::make($validatedData['password']);
        $validatedData['employee_id'] = $this->generateEmployeeId();
        
        $user = User::create($validatedData);

        // Attach team if one was selected
        if ($teamId) {
            $user->teams()->attach($teamId);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur créé avec succès.');
    }

    public function edit(User $user)
    {
        $departments = Department::all();
        $teams = Team::all();
        return view('admin.users.edit', compact('user', 'departments', 'teams'));
    }

    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => ['required', Rule::in([
                User::ROLE_EMPLOYEE,
                User::ROLE_MANAGER,
                User::ROLE_ADMIN,
                User::ROLE_HR,
                User::ROLE_DEPARTMENT_HEAD
            ])],
            'department_id' => 'required|exists:departments,id',
            'team_id' => 'nullable|exists:teams,id',
            'annual_leave_days' => 'required|integer|min:0',
            'sick_leave_days' => 'required|integer|min:0',
        ]);

        // Get team_id and remove it from validatedData
        $teamId = $request->filled('team_id') ? $validatedData['team_id'] : null;
        unset($validatedData['team_id']);

        // Vérifier s'il existe déjà un chef pour ce département
        if ($validatedData['role'] === User::ROLE_DEPARTMENT_HEAD && $user->role !== User::ROLE_DEPARTMENT_HEAD) {
            $existingHead = User::where('department_id', $validatedData['department_id'])
                ->where('role', User::ROLE_DEPARTMENT_HEAD)
                ->where('id', '!=', $user->id)
                ->exists();

            if ($existingHead) {
                return back()
                    ->withInput()
                    ->withErrors(['role' => 'Ce département a déjà un chef.']);
            }
        }

        if (isset($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }

        $user->update($validatedData);

        // Sync team
        if ($teamId) {
            $user->teams()->sync([$teamId]);
        } else {
            $user->teams()->detach();
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur modifié avec succès.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur supprimé avec succès');
    }

    private function generateEmployeeId()
    {
        $prefix = 'EMP';
        $number = 1;
        
        do {
            $employeeId = $prefix . str_pad($number, 3, '0', STR_PAD_LEFT);
            $exists = User::where('employee_id', $employeeId)->exists();
            $number++;
        } while ($exists);

        return $employeeId;
    }
}
