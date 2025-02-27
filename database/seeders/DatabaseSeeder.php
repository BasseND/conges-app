<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\TestDataSeeder;
use Database\Seeders\ProductionSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        if (app()->environment('production')) {
            $this->call([
                ProductionSeeder::class,
            ]);
        } else {
            $this->call([
                TestDataSeeder::class,
            ]);
        }
    }
}
