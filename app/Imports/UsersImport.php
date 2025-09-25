<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Department;
use App\Events\UserCreated;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class UsersImport implements ToCollection, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    use Importable;

    protected $errors = [];
    protected $successCount = 0;
    protected $errorCount = 0;
    protected $departmentCache = [];
    protected $existingEmails = [];
    protected $existingMatricules = [];
    protected $lastEmployeeId = null;
    protected $departmentHeadsAssigned = []; // Track department heads assigned during this import

    public function collection(Collection $rows)
    {
        // Initialiser les caches pour optimiser les performances
        $this->initializeCaches();
        
        foreach ($rows as $index => $row) {
            try {
                $this->validateRow($row, $index + 2); // +2 car ligne 1 = headers, index commence à 0
                $this->createUser($row);
                $this->successCount++;
            } catch (\Exception $e) {
                $this->errors[] = [
                    'row' => $index + 2,
                    'error' => $e->getMessage(),
                    'data' => $row->toArray()
                ];
                $this->errorCount++;
                Log::error('Erreur import utilisateur ligne ' . ($index + 2) . ': ' . $e->getMessage());
            }
        }
    }
    
    protected function initializeCaches()
    {
        // Cache des départements
        $this->departmentCache = Department::all()->keyBy('name');
        
        // Cache des emails existants
        $this->existingEmails = User::pluck('email')->flip()->toArray();
        
        // Cache des matricules existants
        $this->existingMatricules = User::pluck('matricule')->flip()->toArray();
        
        // Dernier employee_id pour génération optimisée
        $lastUser = User::orderBy('employee_id', 'desc')->first();
        if ($lastUser && preg_match('/EMP(\d+)/', $lastUser->employee_id, $matches)) {
            $this->lastEmployeeId = (int)$matches[1];
        } else {
            $this->lastEmployeeId = 0;
        }
    }

    protected function validateRow($row, $rowNumber)
    {
        $validator = Validator::make($row->toArray(), [
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'sexe' => 'required|in:M,F,Masculin,Féminin,Homme,Femme',
            'email' => 'required|email|unique:users,email',
            'telephone' => 'nullable|string|max:20',
            'poste' => 'required|string|max:255',
            'role' => ['required', Rule::in([
                'employee', 'manager', 'admin', 'hr', 'department_head',
                'employé', 'manager', 'administrateur', 'rh', 'chef_departement'
            ])],
            'departement' => 'required|string',
            'mot_de_passe' => 'nullable|string|min:8',
            'prestataire' => 'nullable|in:oui,non,yes,no,1,0',
            // Champs personnels obligatoires
            'date_naissance' => 'required|date|before:today',
            'adresse' => 'required|string|max:500',
            'etat_civil' => 'required|in:marié,célibataire,veuf,marie,celibataire',
            'nombre_enfants' => 'nullable|integer|min:0|max:20',
            // Champs professionnels obligatoires
            'statut_professionnel' => 'nullable|in:fonctionnaire,contractuel_cdi,contractuel_cdd,contractuel,cdi,cdd',
            'matricule' => 'required|string|max:50|unique:users,matricule',
            'affectation' => 'nullable|string|max:255',
            'categorie' => 'required|in:cadre,agent_de_maitrise,employe,ouvrier,agent_maitrise,employee',
            'section' => 'nullable|string|max:255',
            'service' => 'nullable|string|max:255',
            'date_entree' => 'required|date',
            'date_sortie' => 'nullable|date|after_or_equal:date_entree',
            // Contacts d'urgence
            'contact_urgence_nom' => 'nullable|string|max:255',
            'contact_urgence_telephone' => 'nullable|string|max:20',
            'contact_urgence_relation' => 'nullable|string|max:100'
        ], [
            'prenom.required' => 'Le prénom est obligatoire',
            'nom.required' => 'Le nom est obligatoire',
            'sexe.required' => 'Le sexe est obligatoire',
            'sexe.in' => 'Le sexe doit être M, F, Masculin, Féminin, Homme ou Femme',
            'email.required' => 'L\'email est obligatoire',
            'email.email' => 'L\'email doit être valide',
            'email.unique' => 'Cet email existe déjà',
            'poste.required' => 'Le poste est obligatoire',
            'role.required' => 'Le rôle est obligatoire',
            'role.in' => 'Le rôle doit être: employee, manager, admin, hr ou department_head',
            'departement.required' => 'Le département est obligatoire',
            'mot_de_passe.min' => 'Le mot de passe doit contenir au moins 8 caractères',
            // Messages pour les champs personnels
            'date_naissance.date' => 'La date de naissance doit être une date valide',
            'date_naissance.before' => 'La date de naissance doit être antérieure à aujourd\'hui',
            'adresse.max' => 'L\'adresse ne peut pas dépasser 500 caractères',
            'etat_civil.in' => 'L\'état civil doit être: marié, célibataire ou veuf',
            'nombre_enfants.integer' => 'Le nombre d\'enfants doit être un nombre entier',
            'nombre_enfants.min' => 'Le nombre d\'enfants ne peut pas être négatif',
            'nombre_enfants.max' => 'Le nombre d\'enfants ne peut pas dépasser 20',
            // Messages pour les champs professionnels
            'statut_professionnel.in' => 'Le statut professionnel doit être: fonctionnaire, contractuel_cdi ou contractuel_cdd',
            'matricule.unique' => 'Ce matricule existe déjà',
            'matricule.max' => 'Le matricule ne peut pas dépasser 50 caractères',
            'categorie.in' => 'La catégorie doit être: cadre, agent_de_maitrise, employe ou ouvrier',
            'affectation.max' => 'L\'affectation ne peut pas dépasser 255 caractères',
            'section.max' => 'La section ne peut pas dépasser 255 caractères',
            'service.max' => 'Le service ne peut pas dépasser 255 caractères',
            'date_entree.date' => 'La date d\'entrée doit être une date valide',
            'date_sortie.date' => 'La date de sortie doit être une date valide',
            'date_sortie.after_or_equal' => 'La date de sortie doit être postérieure ou égale à la date d\'entrée',
            // Messages pour les contacts d'urgence
            'contact_urgence_nom.max' => 'Le nom du contact d\'urgence ne peut pas dépasser 255 caractères',
            'contact_urgence_telephone.max' => 'Le téléphone du contact d\'urgence ne peut pas dépasser 20 caractères',
            'contact_urgence_relation.max' => 'La relation du contact d\'urgence ne peut pas dépasser 100 caractères'
        ]);

        if ($validator->fails()) {
            throw new \Exception('Ligne ' . $rowNumber . ': ' . implode(', ', $validator->errors()->all()));
        }
    }

    protected function createUser($row)
    {
        // Normaliser le sexe
        $gender = $this->normalizeGender($row['sexe']);
        
        // Normaliser le rôle
        $role = $this->normalizeRole($row['role']);
        
        // Trouver le département en utilisant le cache
        $departmentName = trim($row['departement']);
        $department = $this->departmentCache->get($departmentName);
        
        if (!$department) {
            // Recherche approximative si pas de correspondance exacte
            $department = $this->departmentCache->first(function($dept) use ($departmentName) {
                return stripos($dept->name, $departmentName) !== false;
            });
        }
        
        if (!$department) {
            throw new \Exception('Département "' . $departmentName . '" introuvable');
        }

        // Vérifier s'il existe déjà un chef pour ce département
        if ($role === User::ROLE_DEPARTMENT_HEAD) {
            // Vérifier s'il y a déjà un chef dans la base de données
            $existingHead = User::where('department_id', $department->id)
                ->where('role', User::ROLE_DEPARTMENT_HEAD)
                ->exists();

            // Vérifier s'il y a déjà un chef assigné pendant cet import
            $headAssignedInImport = in_array($department->id, $this->departmentHeadsAssigned);

            if ($existingHead || $headAssignedInImport) {
                throw new \Exception('Ce département a déjà un chef');
            }

            // Marquer ce département comme ayant reçu un chef
            $this->departmentHeadsAssigned[] = $department->id;
        }

        // Générer un mot de passe par défaut si non fourni
        $password = !empty($row['mot_de_passe']) ? $row['mot_de_passe'] : 'password123';
        
        // Normaliser prestataire
        $isPrestataire = $this->normalizeBoolean($row['prestataire'] ?? 'non');

        // Normaliser les nouveaux champs
        $maritalStatus = $this->normalizeMaritalStatus($row['etat_civil'] ?? null);
        $employmentStatus = $this->normalizeEmploymentStatus($row['statut_professionnel'] ?? null);
        $category = $this->normalizeCategory($row['categorie'] ?? null);
        
        // Récupérer la première entreprise disponible
        $company = \App\Models\Company::first();
        if (!$company) {
            throw new \Exception('Aucune entreprise configurée. Veuillez d\'abord créer une entreprise.');
        }

        $userData = [
            'first_name' => trim($row['prenom']),
            'last_name' => trim($row['nom']),
            'gender' => $gender,
            'email' => trim(strtolower($row['email'])),
            'phone' => $row['telephone'] ?? null,
            'password' => Hash::make($password),
            'position' => trim($row['poste']),
            'role' => $role,
            'department_id' => $department->id,
            'company_id' => $company->id,
            'employee_id' => $this->generateOptimizedEmployeeId(),
            'is_prestataire' => $isPrestataire,
            'is_active' => true,
            // Nouveaux champs
            'marital_status' => $maritalStatus,
            'employment_status' => $employmentStatus,
            'children_count' => !empty($row['nombre_enfants']) ? (int)$row['nombre_enfants'] : 0,
            'matricule' => !empty($row['matricule']) ? trim($row['matricule']) : null,
            'affectation' => !empty($row['affectation']) ? trim($row['affectation']) : null,
            'category' => $category,
            'section' => !empty($row['section']) ? trim($row['section']) : null,
            'service' => !empty($row['service']) ? trim($row['service']) : null
        ];

        // Assigner le solde de congés du département s'il existe
        if ($department->leave_balance_id) {
            $userData['leave_balance_id'] = $department->leave_balance_id;
        }

        // Ajouter les dates si présentes
        if (!empty($row['date_naissance'])) {
            $userData['birth_date'] = $row['date_naissance'];
        }
        
        if (!empty($row['adresse'])) {
            $userData['address'] = trim($row['adresse']);
        }
        
        if (!empty($row['date_entree'])) {
            $userData['entry_date'] = $row['date_entree'];
        }
        
        if (!empty($row['date_sortie'])) {
            $userData['exit_date'] = $row['date_sortie'];
        }
        
        // Ajouter les contacts d'urgence si présents
        if (!empty($row['contact_urgence_nom'])) {
            $userData['emergency_contact_name'] = trim($row['contact_urgence_nom']);
        }
        
        if (!empty($row['contact_urgence_telephone'])) {
            $userData['emergency_contact_phone'] = trim($row['contact_urgence_telephone']);
        }
        
        if (!empty($row['contact_urgence_relation'])) {
            $userData['emergency_contact_relationship'] = trim($row['contact_urgence_relation']);
        }

        $user = User::create($userData);
        
        // Déclencher l'événement de création d'utilisateur
        event(new UserCreated($user));
        
        Log::info('Utilisateur importé avec succès: ' . $user->email);
    }

    protected function normalizeGender($gender)
    {
        $gender = strtolower(trim($gender));
        
        if (in_array($gender, ['m', 'masculin', 'homme'])) {
            return 'M';
        }
        
        if (in_array($gender, ['f', 'féminin', 'femme'])) {
            return 'F';
        }
        
        return strtoupper($gender);
    }

    protected function normalizeRole($role)
    {
        $role = strtolower(trim($role));
        
        $roleMapping = [
            'employé' => User::ROLE_EMPLOYEE,
            'employee' => User::ROLE_EMPLOYEE,
            'manager' => User::ROLE_MANAGER,
            'administrateur' => User::ROLE_ADMIN,
            'admin' => User::ROLE_ADMIN,
            'rh' => User::ROLE_HR,
            'hr' => User::ROLE_HR,
            'chef_departement' => User::ROLE_DEPARTMENT_HEAD,
            'department_head' => User::ROLE_DEPARTMENT_HEAD
        ];
        
        return $roleMapping[$role] ?? $role;
    }

    protected function normalizeBoolean($value)
    {
        $value = strtolower(trim($value));
        return in_array($value, ['oui', 'yes', '1', 'true']);
    }

    protected function normalizeMaritalStatus($maritalStatus)
    {
        if (empty($maritalStatus)) {
            return null;
        }
        
        $maritalStatus = strtolower(trim($maritalStatus));
        
        $maritalMapping = [
            'marié' => User::MARITAL_STATUS_MARRIED,
            'marie' => User::MARITAL_STATUS_MARRIED,
            'célibataire' => User::MARITAL_STATUS_SINGLE,
            'celibataire' => User::MARITAL_STATUS_SINGLE,
            'veuf' => User::MARITAL_STATUS_WIDOWED,
            'veuve' => User::MARITAL_STATUS_WIDOWED
        ];
        
        return $maritalMapping[$maritalStatus] ?? $maritalStatus;
    }

    protected function normalizeEmploymentStatus($employmentStatus)
    {
        if (empty($employmentStatus)) {
            return null;
        }
        
        $employmentStatus = strtolower(trim($employmentStatus));
        
        $employmentMapping = [
            'fonctionnaire' => User::EMPLOYMENT_STATUS_CIVIL_SERVANT,
            'contractuel_cdi' => User::EMPLOYMENT_STATUS_PERMANENT_CONTRACT,
            'contractuel_cdd' => User::EMPLOYMENT_STATUS_FIXED_TERM_CONTRACT,
            'contractuel' => User::EMPLOYMENT_STATUS_PERMANENT_CONTRACT,
            'cdi' => User::EMPLOYMENT_STATUS_PERMANENT_CONTRACT,
            'cdd' => User::EMPLOYMENT_STATUS_FIXED_TERM_CONTRACT
        ];
        
        return $employmentMapping[$employmentStatus] ?? $employmentStatus;
    }

    protected function normalizeCategory($category)
    {
        if (empty($category)) {
            return null;
        }
        
        $category = strtolower(trim($category));
        
        $categoryMapping = [
            'cadre' => User::CATEGORY_EXECUTIVE,
            'agent_de_maitrise' => User::CATEGORY_SUPERVISOR,
            'agent_maitrise' => User::CATEGORY_SUPERVISOR,
            'employe' => User::CATEGORY_EMPLOYEE,
            'employee' => User::CATEGORY_EMPLOYEE,
            'ouvrier' => User::CATEGORY_WORKER
        ];
        
        return $categoryMapping[$category] ?? $category;
    }

    protected function generateEmployeeId()
    {
        do {
            $employeeId = 'EMP' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        } while (User::where('employee_id', $employeeId)->exists());
        
        return $employeeId;
    }
    
    protected function generateOptimizedEmployeeId()
    {
        $this->lastEmployeeId++;
        return 'EMP' . str_pad($this->lastEmployeeId, 4, '0', STR_PAD_LEFT);
    }

    public function batchSize(): int
    {
        return 50; // Réduire la taille des lots pour éviter les timeouts
    }

    public function chunkSize(): int
    {
        return 50; // Réduire la taille des chunks
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getSuccessCount()
    {
        return $this->successCount;
    }

    public function getErrorCount()
    {
        return $this->errorCount;
    }
}