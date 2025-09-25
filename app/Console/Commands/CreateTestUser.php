<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateTestUser extends Command
{
    protected $signature = 'create:test-user';
    protected $description = 'Créer un utilisateur test pour les tests de département';

    public function handle()
    {
        try {
            $user = User::create([
                'first_name' => 'Chef',
                'last_name' => 'Disponible',
                'email' => 'chef.disponible@test.com',
                'password' => Hash::make('password'),
                'role' => 'department_head',
                'department_id' => 2, // Ressources Humaines
                'company_id' => 1,
                'position' => 'Chef de département test',
                'gender' => 'M',
                'birth_date' => '1980-01-01',
                'address' => 'Test Address',
                'marital_status' => User::MARITAL_STATUS_SINGLE,
                'employee_id' => 'TEST' . time(),
                'matricule' => 'MAT' . time(),
                'category' => User::CATEGORY_EXECUTIVE,
                'employment_status' => User::EMPLOYMENT_STATUS_PERMANENT_CONTRACT,
                'entry_date' => '2024-01-01'
            ]);

            $this->info('Utilisateur créé avec succès:');
            $this->info('Nom: ' . $user->first_name . ' ' . $user->last_name);
            $this->info('Email: ' . $user->email);
            $this->info('ID: ' . $user->id);
            $this->info('Rôle: ' . $user->role);
            $this->info('Département ID: ' . $user->department_id);

        } catch (\Exception $e) {
            $this->error('Erreur lors de la création de l\'utilisateur: ' . $e->getMessage());
        }
    }
}