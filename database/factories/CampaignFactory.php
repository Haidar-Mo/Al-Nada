<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Campaign>
 */
class CampaignFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->monthName(),
            'description' => fake()->text('200'),
            'cost' => fake()->numberBetween(500000, 10000000),
            'is_donateable' => fake()->randomElement([1, 0]),
            'is_volunteerable' => fake()->randomElement([1, 0]),
            'number_of_Beneficiary' => fake()->numberBetween(50, 1000),
            'image' => 'Campaign/campaign.png',
            'start_date' => fake()->date(),
            'end_date' => null,
        ];
    }
}
