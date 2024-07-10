<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\kitchen>
 */
class KitchenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'namme' => fake()->name(),
            'maker_name' => fake()->name(),
            'price' => fake()->numberBetween(50000, 500000),
            'description' => fake()->sentence(),
            'is_available' => fake()->boolean(),
            'image' => 'Kitchen/kitchen.jpg',
        ];
    }
}
