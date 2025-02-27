<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ProductionSeeder extends Seeder
{
    public function run()
    {
        // Créer les départements de base
        $departments = [
            [
                'name' => 'Ressources Humaines',
                'code' => 'RH',
                'description' => 'Département des ressources humaines'
            ],
            [
                'name' => 'Informatique',
                'code' => 'IT',
                'description' => 'Département informatique'
            ],
            [
                'name' => 'Finance',
                'code' => 'FIN',
                'description' => 'Département finance'
            ]
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }

        // Créer un utilisateur admin par défaut
        User::create([
            'name' => 'Admin',
            'email' => 'admin@conges-app.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin123'), // À changer après le premier login
            'role' => 'admin',
            'department_id' => Department::where('code', 'IT')->first()->id,
        ]);
    }
}
