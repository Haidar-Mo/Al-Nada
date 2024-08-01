<?php

namespace Database\Factories;

use App\Models\User;
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
        $user_IDs = User::all()->pluck('id');
        return [
            'user_id' => fake()->randomElement($user_IDs),
            'type' => 'مالي',
            'amount' => fake()->randomNumber(7),
            'description' => null,
            'phone_number' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'status' => fake()->randomElement(['جديد', 'تم الاستلام', 'قيد المعالجة', 'ملغي']),

        ];
    }
}
