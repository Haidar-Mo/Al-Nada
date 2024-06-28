<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Wallet>
 */
class WalletFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user_IDS = User::all()->pluck('id')->toArray();
        return [
            'user_id'=>fake()->unique()->randomElement($user_IDS),
            'balance'=>fake()->numberBetween(1000000,9999999)
        ];
    }
}
