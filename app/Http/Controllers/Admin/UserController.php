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
use App\Events\UserCreated;
use App\Events\UserUpdated;

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
        \Log::info('UserController store method called');
        
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
                'leave_balance_id' => 'nullable|exists:leave_balances,id',
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
                'leave_balance_id.exists' => 'Le solde de congés sélectionné n\'existe pas.'
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
            
            // Déclencher l'événement de création d'utilisateur
            \Log::info('About to trigger UserCreated event for user: ' . $user->email);
            event(new UserCreated($user));
            \Log::info('UserCreated event triggered successfully for user: ' . $user->email);

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
            'team_id.exists' => 'L\'équipe sélectionnée n\'existe pas.'
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
        
        // Déclencher l'événement de création d'utilisateur
        \Log::info('About to trigger UserCreated event for user: ' . $user->email);
        event(new UserCreated($user));
        \Log::info('UserCreated event triggered successfully for user: ' . $user->email);

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
        $user->load([
            'department', 
            'teams', 
            'leaveBalance',
            'company.leaveBalances' => function($query) {
                $query->where('is_default', true);
            },
            'contracts' => function($query) {
                $query->orderBy('date_debut', 'desc');
            }
        ]);

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
            'leave_balance_id' => 'nullable|exists:leave_balances,id',
            'maternity_leave_days' => 'nullable|integer|min:0',
            'paternity_leave_days' => 'nullable|integer|min:0',
            'special_leave_days' => 'nullable|integer|min:0',
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
            'leave_balance_id.exists' => 'Le solde de congés sélectionné n\'existe pas.'
        ]);

        // Sauvegarder les anciennes données
        $oldData = $user->only(['role', 'department_id', 'first_name', 'last_name', 'email']);
        
        \Log::info('User update - Old data: ' . json_encode($oldData));
        \Log::info('User update - New data: ' . json_encode($validatedData));

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
        
        // Récupérer les nouvelles données
        $newData = $user->fresh()->only(['role', 'department_id', 'first_name', 'last_name', 'email']);
        
        // Déclencher l'événement UserUpdated
        event(new UserUpdated($user, $oldData, $newData));
        \Log::info('UserUpdated event dispatched for user: ' . $user->email);

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
            'confirm_text' => 'required|string',
        ]);

        // Vérifier que le texte de confirmation correspond
        if ($request->confirm_text !== 'CONFIRMER') {
            return response()->json([
                'success' => false,
                'message' => 'Le texte de confirmation ne correspond pas. Veuillez saisir "CONFIRMER" pour confirmer la suppression.'
            ], 422);
        }

        // Vérifier que l'utilisateur ne peut pas supprimer son propre compte
        if ($user->id === auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Vous ne pouvez pas supprimer votre propre compte.'
            ], 403);
        }

        $userName = $user->first_name . ' ' . $user->last_name;
        $user->delete();
        
        return response()->json([
            'success' => true,
            'message' => "L'utilisateur {$userName} a été supprimé avec succès."
        ]);
    }

    public function toggleStatus(Request $request, User $user)
    {
        // Vérifier que l'utilisateur ne peut pas désactiver son propre compte
        if ($user->id === auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Vous ne pouvez pas modifier votre propre statut.'
            ], 403);
        }

        // Basculer le statut
        $user->is_active = !$user->is_active;
        $user->save();

        $status = $user->is_active ? 'activé' : 'désactivé';
        
        return response()->json([
            'success' => true,
            'message' => "L'utilisateur {$user->first_name} {$user->last_name} a été {$status} avec succès.",
            'is_active' => $user->is_active
        ]);
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
