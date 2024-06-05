<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Administration>
 */
class AdministrationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $IDs = Employee::pluck('id');
        return [
            'employee_id' => fake()->unique()->randomElement($IDs),
            'user_name' => $this->faker->userName(),
            'password' => bcrypt('password'),
        ];
    }
}
