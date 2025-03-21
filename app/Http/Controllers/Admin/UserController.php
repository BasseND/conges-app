<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Department;
use App\Models\Contract;
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
                $q->where('first_name', 'like', "%{$searchTerm}%")
                  ->orWhere('last_name', 'like', "%{$searchTerm}%")
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
        $sortField = $request->input('sort', 'first_name');
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

        try {
            $validatedData = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'phone' => 'nullable|string|max:20',
                'password' => 'required|string|min:8|confirmed',
                'position' => 'required|string|max:255',
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
                'is_prestataire' => 'nullable'
            ], [
                'first_name.required' => 'Le prénom est obligatoire.',
                'last_name.required' => 'Le nom est obligatoire.',
                'email.required' => 'L\'adresse email est obligatoire.',
                'email.email' => 'L\'adresse email doit être valide.',
                'email.unique' => 'Cette adresse email est déjà utilisée.',
                'password.required' => 'Le mot de passe est obligatoire.',
                'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
                'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
                'position.required' => 'Le poste est obligatoire.',
                'role.required' => 'Le rôle est obligatoire.',
                'role.in' => 'Le rôle sélectionné n\'est pas valide.',
                'department_id.required' => 'Le département est obligatoire.',
                'department_id.exists' => 'Le département sélectionné n\'existe pas.',
                'team_id.exists' => 'L\'équipe sélectionnée n\'existe pas.',
                'annual_leave_days.required' => 'Le nombre de jours de congés annuels est obligatoire.',
                'annual_leave_days.integer' => 'Le nombre de jours de congés annuels doit être un nombre entier.',
                'annual_leave_days.min' => 'Le nombre de jours de congés annuels ne peut pas être négatif.',
                'sick_leave_days.required' => 'Le nombre de jours de congés maladie est obligatoire.',
                'sick_leave_days.integer' => 'Le nombre de jours de congés maladie doit être un nombre entier.',
                'sick_leave_days.min' => 'Le nombre de jours de congés maladie ne peut pas être négatif.'
            ]);

            Log::info('Validated data:', $validatedData);

            // Traiter la valeur is_prestataire
            $validatedData['is_prestataire'] = $request->has('is_prestataire');
            
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
                ->with('success', 'L\'utilisateur a été créé avec succès.');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error: ' . json_encode($e->errors()));
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error creating user: ' . $e->getMessage());
            return back()
                ->withInput()
                ->withErrors(['general' => 'Une erreur est survenue lors de la création de l\'utilisateur. Veuillez réessayer.']);
        }
    }

    public function storeOLD(Request $request)
    {
        Log::info('Request data:', $request->all());

        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'position' => 'required|string|max:255',
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
            'is_prestataire' => 'nullable'
        ], [
            'first_name.required' => 'Le prénom est obligatoire.',
            'last_name.required' => 'Le nom est obligatoire.',
            'email.required' => 'L\'adresse email est obligatoire.',
            'email.email' => 'L\'adresse email doit être valide.',
            'email.unique' => 'Cette adresse email est déjà utilisée.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
            'position.required' => 'Le poste est obligatoire.',
            'role.required' => 'Le rôle est obligatoire.',
            'role.in' => 'Le rôle sélectionné n\'est pas valide.',
            'department_id.required' => 'Le département est obligatoire.',
            'department_id.exists' => 'Le département sélectionné n\'existe pas.',
            'team_id.exists' => 'L\'équipe sélectionnée n\'existe pas.',
            'annual_leave_days.required' => 'Le nombre de jours de congés annuels est obligatoire.',
            'annual_leave_days.integer' => 'Le nombre de jours de congés annuels doit être un nombre entier.',
            'annual_leave_days.min' => 'Le nombre de jours de congés annuels ne peut pas être négatif.',
            'sick_leave_days.required' => 'Le nombre de jours de congés maladie est obligatoire.',
            'sick_leave_days.integer' => 'Le nombre de jours de congés maladie doit être un nombre entier.',
            'sick_leave_days.min' => 'Le nombre de jours de congés maladie ne peut pas être négatif.'
        ]);

        Log::info('Validated data:', $validatedData);

        // Traiter la valeur is_prestataire
        $validatedData['is_prestataire'] = $request->has('is_prestataire');
        
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
            ->with('success', 'L\'utilisateur a été créé avec succès.');
    }

    public function edit(User $user)
    {
        $departments = Department::all();
        $teams = Team::all();
    
        return view('admin.users.edit', compact('user', 'departments', 'teams'));
    }

    public function show(User $user)
    {

        $departments = Department::all();
        $teams = Team::all();
        // Charger les relations nécessaires
        $user->load(['department', 'teams', 'contracts' => function($query) {
            $query->orderBy('date_debut', 'desc');
        }]);

        return view('admin.users.show', compact('user', 'departments', 'teams'));
    }

    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
            'position' => 'required|string|max:255',
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
            'is_prestataire' => 'nullable'
        ], [
            'first_name.required' => 'Le prénom est obligatoire.',
            'last_name.required' => 'Le nom est obligatoire.',
            'email.required' => 'L\'adresse email est obligatoire.',
            'email.email' => 'L\'adresse email doit être valide.',
            'email.unique' => 'Cette adresse email est déjà utilisée.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
            'position.required' => 'Le poste est obligatoire.',
            'role.required' => 'Le rôle est obligatoire.',
            'role.in' => 'Le rôle sélectionné n\'est pas valide.',
            'department_id.required' => 'Le département est obligatoire.',
            'department_id.exists' => 'Le département sélectionné n\'existe pas.',
            'team_id.exists' => 'L\'équipe sélectionnée n\'existe pas.',
            'annual_leave_days.required' => 'Le nombre de jours de congés annuels est obligatoire.',
            'annual_leave_days.integer' => 'Le nombre de jours de congés annuels doit être un nombre entier.',
            'annual_leave_days.min' => 'Le nombre de jours de congés annuels ne peut pas être négatif.',
            'sick_leave_days.required' => 'Le nombre de jours de congés maladie est obligatoire.',
            'sick_leave_days.integer' => 'Le nombre de jours de congés maladie doit être un nombre entier.',
            'sick_leave_days.min' => 'Le nombre de jours de congés maladie ne peut pas être négatif.'
        ]);

        // Traiter la valeur is_prestataire
        $validatedData['is_prestataire'] = $request->has('is_prestataire');

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

    // public function destroy(User $user)
    // {
    //     $user->delete();
    //     return redirect()->route('admin.users.index')
    //         ->with('success', 'Utilisateur supprimé avec succès');
    // }

    public function destroy(Request $request, User $user)
    {
        $request->validate([
            'confirm_first_name' => 'required|string',
            'confirm_last_name' => 'required|string',
        ]);

        // Vérifier que les noms et prénoms correspondent
        if ($request->confirm_first_name !== $user->first_name || 
            $request->confirm_last_name !== $user->last_name) {
            return back()
                ->withErrors(['userDeletion' => [
                    'confirm_first_name' => 'Le prénom saisi ne correspond pas.',
                    'confirm_last_name' => 'Le nom saisi ne correspond pas.'
                ]])
                ->with('error', 'Les informations saisies ne correspondent pas à l\'utilisateur.');
        }

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

    // Profile Infos Dialog Edit
    
}
