<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Volunteer>
 */
class VolunteerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->name(),
            'last_name' => fake()->name(),
            'birh_date' => fake()->date(),
            'phone_number' => fake()->phoneNumber(),
            'academic_leve' => fake()->randomElement(['غير محدد', 'ابتدائي', 'اعدادي', 'ثانوي', 'جامعي']),
            'status' => fake()->randomElement(['نشط', 'غير نشط'])
        ];
    }
}
