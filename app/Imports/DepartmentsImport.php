<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Company;
use App\Models\Department;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class DepartmentsImport implements ToCollection, WithHeadingRow, WithBatchInserts, WithChunkReading
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
                $this->createDepartment($row);
                $this->successCount++;
            } catch (\Exception $e) {
                $this->errors[] = [
                    'row' => $index + 2,
                    'error' => $e->getMessage(),
                    'data' => $row->toArray()
                ];
                $this->errorCount++;
                Log::error('Erreur import département ligne ' . ($index + 2) . ': ' . $e->getMessage());
            }
        }
    }

    protected function validateRow($row, $rowNumber)
    {
        $validator = Validator::make($row->toArray(), [
            'nom' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:departments,code',
            'description' => 'nullable|string|max:500',
            'chef_email' => 'nullable|email|exists:users,email',
            'societe' => 'nullable|string',
            'solde_conges' => 'nullable|string'
        ], [
            'nom.required' => 'Le nom du département est obligatoire',
            'nom.max' => 'Le nom du département ne peut pas dépasser 255 caractères',
            'code.required' => 'Le code du département est obligatoire',
            'code.max' => 'Le code du département ne peut pas dépasser 10 caractères',
            'code.unique' => 'Ce code de département existe déjà',
            'description.max' => 'La description ne peut pas dépasser 500 caractères',
            'chef_email.email' => 'L\'email du chef doit être valide',
            'chef_email.exists' => 'Cet email de chef n\'existe pas dans le système'
        ]);

        if ($validator->fails()) {
            throw new \Exception('Ligne ' . $rowNumber . ': ' . implode(', ', $validator->errors()->all()));
        }
    }

    protected function createDepartment($row)
    {
        // Trouver la société si spécifiée
        $company = null;
        if (!empty($row['societe'])) {
            $company = Company::where('name', 'like', '%' . trim($row['societe']) . '%')->first();
            if (!$company) {
                throw new \Exception('Société "' . $row['societe'] . '" introuvable');
            }
        }

        // Trouver le chef si spécifié
        $head = null;
        if (!empty($row['chef_email'])) {
            $head = User::where('email', trim(strtolower($row['chef_email'])))->first();
            if (!$head) {
                throw new \Exception('Chef avec l\'email "' . $row['chef_email'] . '" introuvable');
            }

            // Vérifier que l'utilisateur n'est pas déjà chef d'un autre département
            $existingDepartment = Department::where('head_id', $head->id)->first();
            if ($existingDepartment) {
                throw new \Exception('Cet utilisateur est déjà chef du département "' . $existingDepartment->name . '"');
            }
        }

        // Note: Le système de solde de congés a été remplacé par SpecialLeaveType

        $departmentData = [
            'name' => trim($row['nom']),
            'code' => strtoupper(trim($row['code'])),
            'description' => !empty($row['description']) ? trim($row['description']) : null,
            'head_id' => $head ? $head->id : null,
            'company_id' => $company ? $company->id : null,
            // 'leave_balance_id' supprimé - remplacé par SpecialLeaveType
        ];

        $department = Department::create($departmentData);
        
        // Si un chef a été assigné, mettre à jour son rôle et département
        if ($head) {
            $head->update([
                'role' => User::ROLE_DEPARTMENT_HEAD,
                'department_id' => $department->id
            ]);
        }
        
        Log::info('Département importé avec succès: ' . $department->name);
    }

    public function batchSize(): int
    {
        return 50;
    }

    public function chunkSize(): int
    {
        return 50;
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