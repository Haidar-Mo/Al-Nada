<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::all()->pluck('id')->toArray();
        return [
            'user_id' => fake()->randomElement($user),
            'orderable_type' => $this->faker->randomElement(['App\Models\Product', 'App\Models\Kitchen']), // Replace with your actual orderable models
            'orderable_id' => function (array $attributes) {
                // Dynamically get an existing ID from the orderable_type model's table
                $model = app($attributes['orderable_type']);
                return $model::inRandomOrder()->first()->id;
            },
            'phone_number' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'note' => $this->faker->sentence,
            'status' => $this->faker->randomElement(['ملغي', 'تم الاستلام', 'قيد المعالجة', 'جديد']),
            'created_at' => fake()->dateTimeBetween('-1 years', '-1 months'),
            'updated_at' => fake()->dateTimeBetween('-1 months', 'now'),
        ];
    }
}
