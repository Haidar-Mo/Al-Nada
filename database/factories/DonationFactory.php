<?php

namespace Database\Factories;

use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Donation>
 */
class DonationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $wallet_IDs = Wallet::all()->pluck('id');
        return [
            'wallet_id' => fake()->randomElement($wallet_IDs),
            'type' => 'مالي',
            'amount' => fake()->randomNumber(7),
            'deliver_type' => 'الكتروني',
            'description' => 'لايوجد',

        ];
    }
}
