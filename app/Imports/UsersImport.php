<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Department;
use App\Models\LeaveBalance;
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
            'prestataire' => 'nullable|in:oui,non,yes,no,1,0'
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
            'mot_de_passe.min' => 'Le mot de passe doit contenir au moins 8 caractères'
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
            'is_active' => true
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