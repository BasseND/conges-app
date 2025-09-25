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
use App\Imports\UsersImport;
use App\Jobs\ProcessUsersImport;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Optimisation : Eager loading avec sélection des colonnes nécessaires
        $query = User::query()
            ->select([
                'id', 'first_name', 'last_name', 'email', 'matricule', 
                'role', 'department_id', 'is_active', 'gender', 'created_at'
            ])
            ->with(['department:id,name,code']);

        // Recherche par nom ou email
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('first_name', 'like', "%{$searchTerm}%")
                  ->orWhere('last_name', 'like', "%{$searchTerm}%")
                  ->orWhere('email', 'like', "%{$searchTerm}%");
            });
        }

        // Recherche par matricule
        if ($request->filled('matricule')) {
            $query->where('matricule', 'like', "%{$request->matricule}%");
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

        // Pagination optimisée : 50 utilisateurs par page au lieu de 20
        $perPage = $request->input('per_page', 50);
        $perPage = in_array($perPage, [25, 50, 100]) ? $perPage : 50;
        
        $users = $query->paginate($perPage)->appends(request()->query());
        
        // Optimisation : Charger seulement les départements nécessaires pour les filtres
        $departments = Department::select('id', 'name')->orderBy('name')->get();
        $company = \App\Models\Company::select('id', 'name')->first();

        return view('admin.users.index', compact('users', 'departments', 'company'));
    }

    public function create()
    {
        $departments = Department::all();
        $teams = Team::all();
        $company = \App\Models\Company::first();
        return view('admin.users.create', compact('departments', 'teams', 'company'));
    }

    public function store(Request $request)
    {
    

        try {
            $validatedData = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'gender' => 'required|in:M,F',
                'email' => 'required|string|email|max:255|unique:users',
                'phone' => 'nullable|string|max:20',
                'birth_date' => 'required|date|before:today',
                'address' => 'required|string|max:500',
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
                'company_id' => 'required|exists:companies,id',
                'team_id' => 'nullable|exists:teams,id',
                'leave_balance_id' => 'nullable|exists:leave_balances,id',
                'is_prestataire' => 'nullable',
                // Nouveaux champs obligatoires
                'marital_status' => ['required', Rule::in(array_keys(User::getMaritalStatusOptions()))],
                'employment_status' => ['nullable', Rule::in(array_keys(User::getEmploymentStatusOptions()))],
                'children_count' => 'nullable|integer|min:0|max:20',
                'matricule' => 'required|string|max:50|unique:users,matricule',
                'affectation' => 'nullable|string|max:255',
                'category' => ['required', Rule::in(array_keys(User::getCategoryOptions()))],
                'section' => 'nullable|string|max:255',
                'service' => 'nullable|string|max:255',
                'entry_date' => 'required|date',
                'exit_date' => 'nullable|date|after_or_equal:entry_date'
            ], [
                'first_name.required' => 'Le prénom est obligatoire.',
                'last_name.required' => 'Le nom est obligatoire.',
                'gender.required' => 'Le sexe est obligatoire.',
                'gender.in' => 'Le sexe doit être Masculin ou Féminin.',
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
                'company_id.required' => 'L\'entreprise est obligatoire.',
                'company_id.exists' => 'L\'entreprise sélectionnée n\'existe pas.',
                'team_id.exists' => 'L\'équipe sélectionnée n\'existe pas.',
                'leave_balance_id.exists' => 'Le solde de congés sélectionné n\'existe pas.',
                'birth_date.required' => 'La date de naissance est obligatoire.',
                'address.required' => 'L\'adresse est obligatoire.',
                // Messages pour les nouveaux champs obligatoires
                'marital_status.required' => 'L\'état civil est obligatoire.',
                'marital_status.in' => 'L\'état civil sélectionné n\'est pas valide.',
                'matricule.required' => 'Le matricule est obligatoire.',
                'category.required' => 'La catégorie est obligatoire.',
                'entry_date.required' => 'La date d\'entrée est obligatoire.',
                'employment_status.in' => 'Le statut professionnel sélectionné n\'est pas valide.',
                'children_count.integer' => 'Le nombre d\'enfants doit être un nombre entier.',
                'children_count.min' => 'Le nombre d\'enfants ne peut pas être négatif.',
                'children_count.max' => 'Le nombre d\'enfants ne peut pas dépasser 20.',
                'matricule.unique' => 'Ce matricule est déjà utilisé.',
                'matricule.max' => 'Le matricule ne peut pas dépasser 50 caractères.',
                'affectation.max' => 'L\'affectation ne peut pas dépasser 255 caractères.',
                'category.in' => 'La catégorie sélectionnée n\'est pas valide.',
                'section.max' => 'La section ne peut pas dépasser 255 caractères.',
                'service.max' => 'Le service ne peut pas dépasser 255 caractères.',
                'entry_date.date' => 'La date d\'entrée doit être une date valide.',
                'exit_date.date' => 'La date de sortie doit être une date valide.',
                'exit_date.after_or_equal' => 'La date de sortie doit être postérieure ou égale à la date d\'entrée.'
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
            
            // Si aucun solde de congés n'est sélectionné, utiliser celui du département s'il existe
            if (empty($validatedData['leave_balance_id'])) {
                $department = Department::find($validatedData['department_id']);
                if ($department && $department->leave_balance_id) {
                    $validatedData['leave_balance_id'] = $department->leave_balance_id;
                }
            }
            
            $user = User::create($validatedData);

            // Attach team if one was selected
            if ($teamId) {
                $user->teams()->attach($teamId);
            }
            
            // Déclencher l'événement de création d'utilisateur
            event(new UserCreated($user));

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
            'company_id' => 'required|exists:companies,id',
            'team_id' => 'nullable|exists:teams,id',
            'is_prestataire' => 'nullable'
        ], [
            'first_name.required' => 'Le prénom est obligatoire.',
            'last_name.required' => 'Le nom est obligatoire.',
            'gender.required' => 'Le sexe est obligatoire.',
            'gender.in' => 'Le sexe doit être Masculin ou Féminin.',
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
            'company_id.required' => 'L\'entreprise est obligatoire.',
            'company_id.exists' => 'L\'entreprise sélectionnée n\'existe pas.',
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
        event(new UserCreated($user));

        return redirect()->route('admin.users.index')
            ->with('success', 'L\'utilisateur a été créé avec succès.');
    }

    public function edit(User $user)
    {
        $departments = Department::all();
        $teams = Team::all();
        $company = \App\Models\Company::first();
    
        return view('admin.users.edit', compact('user', 'departments', 'teams', 'company'));
    }

    public function show(User $user)
    {
        $departments = Department::all();
        $teams = Team::all();
        
        // Récupérer les types de contrats depuis la base de données
        $company = \App\Models\Company::first();
        $contractTypes = $company ? $company->contractTypes()->active()->orderBy('name')->get() : collect();
        
        // Charger les relations nécessaires
        $user->load([
            'department', 
            'teams', 
            // 'leaveBalance' supprimé - remplacé par SpecialLeaveType
            // 'company.leaveBalances' supprimé - remplacé par SpecialLeaveType
            'contracts' => function($query) {
                $query->orderBy('date_debut', 'desc');
            }
        ]);

        return view('admin.users.show', compact('user', 'departments', 'teams', 'contractTypes'));
    }

    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|in:M,F',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
                'birth_date' => 'required|date|before:today',
                'address' => 'required|string|max:500',
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
            'is_prestataire' => 'nullable',
            // Nouveaux champs obligatoires
            'marital_status' => ['required', Rule::in(array_keys(User::getMaritalStatusOptions()))],
            'employment_status' => ['nullable', Rule::in(array_keys(User::getEmploymentStatusOptions()))],
            'children_count' => 'nullable|integer|min:0|max:20',
            'matricule' => ['required', 'string', 'max:50', Rule::unique('users')->ignore($user->id)],
            'affectation' => 'nullable|string|max:255',
            'category' => ['required', Rule::in(array_keys(User::getCategoryOptions()))],
            'section' => 'nullable|string|max:255',
            'service' => 'nullable|string|max:255',
            'entry_date' => 'required|date',
            'exit_date' => 'nullable|date|after_or_equal:entry_date'
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
            'leave_balance_id.exists' => 'Le solde de congés sélectionné n\'existe pas.',
            'birth_date.required' => 'La date de naissance est obligatoire.',
            'address.required' => 'L\'adresse est obligatoire.',
            // Messages pour les nouveaux champs obligatoires
            'marital_status.required' => 'L\'état civil est obligatoire.',
            'marital_status.in' => 'Le statut matrimonial sélectionné n\'est pas valide.',
            'matricule.required' => 'Le matricule est obligatoire.',
            'category.required' => 'La catégorie est obligatoire.',
            'entry_date.required' => 'La date d\'entrée est obligatoire.',
            'employment_status.in' => 'Le statut professionnel sélectionné n\'est pas valide.',
            'children_count.integer' => 'Le nombre d\'enfants doit être un nombre entier.',
            'children_count.min' => 'Le nombre d\'enfants ne peut pas être négatif.',
            'children_count.max' => 'Le nombre d\'enfants ne peut pas dépasser 20.',
            'matricule.unique' => 'Ce matricule est déjà utilisé.',
            'matricule.max' => 'Le matricule ne peut pas dépasser 50 caractères.',
            'affectation.max' => 'L\'affectation ne peut pas dépasser 255 caractères.',
            'category.in' => 'La catégorie sélectionnée n\'est pas valide.',
            'section.max' => 'La section ne peut pas dépasser 255 caractères.',
            'service.max' => 'Le service ne peut pas dépasser 255 caractères.',
            'entry_date.date' => 'La date d\'entrée doit être une date valide.',
            'exit_date.date' => 'La date de sortie doit être une date valide.',
            'exit_date.after_or_equal' => 'La date de sortie doit être postérieure ou égale à la date d\'entrée.'
        ]);

        // Sauvegarder les anciennes données
        $oldData = $user->only(['role', 'department_id', 'first_name', 'last_name', 'email']);

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

        // Redirection conditionnelle selon la source de la requête
        if ($request->has('source') && $request->input('source') === 'modal') {
            // Si la requête provient du modal, rester sur la page de détail
            return redirect()->route('admin.users.show', $user)
                ->with('success', 'Utilisateur modifié avec succès.');
        } else {
            // Si la requête provient des formulaires classiques, retourner à la liste
            return redirect()->route('admin.users.index')
                ->with('success', 'Utilisateur modifié avec succès.');
        }
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
    
    /**
     * Récupérer la liste des utilisateurs pour l'API
     */
    public function apiIndex()
    {
        $users = User::select('id', 'first_name', 'last_name', 'email')
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->first_name . ' ' . $user->last_name,
                    'email' => $user->email
                ];
            });

        return response()->json($users);
    }

    /**
     * Affiche la page d'import en masse
     */
    public function showImport()
    {
        return view('admin.users.import');
    }

    /**
     * Traite l'import en masse d'utilisateurs
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
            $file = $request->file('file');
            
            // Vérifier la taille du fichier pour décider du mode de traitement
            $fileSizeKB = $file->getSize() / 1024;
            
            if ($fileSizeKB > 500) { // Si le fichier fait plus de 500KB, traiter en arrière-plan
                return $this->importInBackground($file);
            }
            
            // Traitement synchrone pour les petits fichiers
            // Augmenter les limites pour l'import
            ini_set('max_execution_time', 300); // 5 minutes
            ini_set('memory_limit', '512M');
            
            $import = new UsersImport();
            Excel::import($import, $file);

            $successCount = $import->getSuccessCount();
            $errorCount = $import->getErrorCount();
            $errors = $import->getErrors();

            // Toujours afficher un message, même s'il n'y a que des erreurs
            if ($errorCount > 0 && $successCount > 0) {
                return redirect()->route('admin.users.index')
                    ->with('warning', "Import terminé avec {$successCount} utilisateurs créés et {$errorCount} erreurs.")
                    ->with('import_errors', $errors);
            } elseif ($errorCount > 0 && $successCount === 0) {
                return redirect()->route('admin.users.import')
                    ->with('error', "Aucun utilisateur n'a pu être importé. {$errorCount} erreurs détectées.")
                    ->with('import_errors', $errors);
            } elseif ($successCount > 0) {
                return redirect()->route('admin.users.index')
                    ->with('success', "{$successCount} utilisateurs ont été importés avec succès.");
            } else {
                return redirect()->route('admin.users.import')
                    ->with('warning', "Aucun utilisateur n'a été traité. Vérifiez le format de votre fichier.");
            }

        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'import d\'utilisateurs: ' . $e->getMessage());
            return redirect()->route('admin.users.import')
                ->with('error', 'Erreur lors de l\'import: ' . $e->getMessage());
        }
    }
    
    /**
     * Traite l'import en arrière-plan pour les gros fichiers
     */
    protected function importInBackground($file)
    {
        try {
            // Stocker le fichier temporairement
            $fileName = 'imports/' . uniqid() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('imports', basename($fileName));
            
            // Lancer le job en arrière-plan
            ProcessUsersImport::dispatch($filePath, auth()->id());
            
            return redirect()->route('admin.users.import')
                ->with('info', 'Votre fichier est volumineux et sera traité en arrière-plan. Vous recevrez une notification une fois l\'import terminé. Consultez les logs pour suivre le progrès.');
                
        } catch (\Exception $e) {
            Log::error('Erreur lors du lancement de l\'import en arrière-plan: ' . $e->getMessage());
            return redirect()->route('admin.users.import')
                ->with('error', 'Erreur lors du lancement de l\'import: ' . $e->getMessage());
        }
    }

    /**
     * Télécharge le modèle Excel pour l'import
     */
    public function downloadTemplate()
    {
        $headers = [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="modele_import_utilisateurs.xlsx"'
        ];

        return Excel::download(new \App\Exports\UsersTemplateExport(), 'modele_import_utilisateurs.xlsx', \Maatwebsite\Excel\Excel::XLSX, $headers);
    }
}
