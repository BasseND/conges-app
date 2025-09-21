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

    public function collection(Collection $rows)
    {
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
            // Nouveaux champs
            'etat_civil' => 'nullable|in:marié,célibataire,veuf,marie,celibataire',
            'statut_professionnel' => 'nullable|in:fonctionnaire,contractuel_cdi,contractuel_cdd,contractuel,cdi,cdd',
            'nombre_enfants' => 'nullable|integer|min:0|max:20',
            'matricule' => 'nullable|string|max:50|unique:users,matricule',
            'affectation' => 'nullable|string|max:255',
            'categorie' => 'nullable|in:cadre,agent_de_maitrise,employe,ouvrier,agent_maitrise,employee',
            'section' => 'nullable|string|max:255',
            'service' => 'nullable|string|max:255'
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
            // Messages pour les nouveaux champs
            'etat_civil.in' => 'L\'état civil doit être: marié, célibataire ou veuf',
            'statut_professionnel.in' => 'Le statut professionnel doit être: fonctionnaire, contractuel_cdi ou contractuel_cdd',
            'nombre_enfants.integer' => 'Le nombre d\'enfants doit être un nombre entier',
            'nombre_enfants.min' => 'Le nombre d\'enfants ne peut pas être négatif',
            'nombre_enfants.max' => 'Le nombre d\'enfants ne peut pas dépasser 20',
            'matricule.unique' => 'Ce matricule existe déjà',
            'matricule.max' => 'Le matricule ne peut pas dépasser 50 caractères',
            'categorie.in' => 'La catégorie doit être: cadre, agent_de_maitrise, employe ou ouvrier',
            'affectation.max' => 'L\'affectation ne peut pas dépasser 255 caractères',
            'section.max' => 'La section ne peut pas dépasser 255 caractères',
            'service.max' => 'Le service ne peut pas dépasser 255 caractères'
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
        
        // Trouver le département
        $department = Department::where('name', 'like', '%' . trim($row['departement']) . '%')->first();
        if (!$department) {
            throw new \Exception('Département "' . $row['departement'] . '" introuvable');
        }

        // Vérifier s'il existe déjà un chef pour ce département
        if ($role === User::ROLE_DEPARTMENT_HEAD) {
            $existingHead = User::where('department_id', $department->id)
                ->where('role', User::ROLE_DEPARTMENT_HEAD)
                ->exists();

            if ($existingHead) {
                throw new \Exception('Ce département a déjà un chef');
            }
        }

        // Générer un mot de passe par défaut si non fourni
        $password = !empty($row['mot_de_passe']) ? $row['mot_de_passe'] : 'password123';
        
        // Normaliser prestataire
        $isPrestataire = $this->normalizeBoolean($row['prestataire'] ?? 'non');

        // Normaliser les nouveaux champs
        $maritalStatus = $this->normalizeMaritalStatus($row['etat_civil'] ?? null);
        $employmentStatus = $this->normalizeEmploymentStatus($row['statut_professionnel'] ?? null);
        $category = $this->normalizeCategory($row['categorie'] ?? null);
        
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
            'employee_id' => $this->generateEmployeeId(),
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

    public function batchSize(): int
    {
        return 100;
    }

    public function chunkSize(): int
    {
        return 100;
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