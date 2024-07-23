<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Report>
 */
class ReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
        $user_IDs = User::all()->pluck('id')->toArray();
        return [
            'user_id' => fake()->randomElement($user_IDs),
            'description' => fake('ar_SA')->text(500),
        ];
    }
}
