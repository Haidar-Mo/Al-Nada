<?php

namespace Database\Factories;

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
        return [
            'wallet_id' => 12,
            'type' => 'مالي',
            'amount' => fake()->randomNumber(7),
            'deliver_type' => 'الكتروني',
            'description' => 'لايوجد',

        ];
    }
}
