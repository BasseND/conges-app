<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'gender' => fake()->randomElement(['M', 'F']),
            'birth_date' => fake()->date(),
            'address' => fake()->address(),
            'marital_status' => fake()->randomElement(['marié', 'célibataire', 'veuf']),
            'employment_status' => fake()->randomElement(['fonctionnaire', 'contractuel_cdi', 'contractuel_cdd']),
            'children_count' => fake()->numberBetween(0, 5),
            'phone' => fake()->phoneNumber(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'role' => fake()->randomElement(['admin', 'employee', 'manager', 'hr_admin', 'department_head']),
            'employee_id' => fake()->unique()->numerify('EMP###'),
            'matricule' => fake()->unique()->numerify('MAT###'),
            'affectation' => fake()->word(),
            'category' => fake()->randomElement(['cadre', 'agent_de_maitrise', 'employe', 'ouvrier']),
            'section' => fake()->word(),
            'service' => fake()->word(),
            'is_active' => true,
            'position' => fake()->jobTitle(),
            'entry_date' => fake()->date(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
