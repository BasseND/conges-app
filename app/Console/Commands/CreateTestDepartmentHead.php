<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateTestDepartmentHead extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-test-department-head';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a test user with department head role';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = User::create([
            'first_name' => 'Chef',
            'last_name' => 'Test',
            'email' => 'chef.test@example.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_DEPARTMENT_HEAD,
            'department_id' => null,
            'birth_date' => '1990-01-01',
            'address' => '123 Rue Test',
            'gender' => 'M',
            'marital_status' => User::MARITAL_STATUS_SINGLE,
            'employment_status' => User::EMPLOYMENT_STATUS_PERMANENT_CONTRACT,
            'children_count' => 0,
            'phone' => '0123456789',
            'employee_id' => 'TEST001',
            'matricule' => 'MAT001',
            'is_active' => true,
            'entry_date' => now()->format('Y-m-d')
        ]);

        $this->info('Utilisateur chef de département créé avec succès:');
        $this->info('Email: ' . $user->email);
        $this->info('ID: ' . $user->id);
    }
}
