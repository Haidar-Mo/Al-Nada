<?php

namespace Database\Factories;

use App\Models\OrphanFamily;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrphanFamilyChild>
 */
class OrphanFamilyChildFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $families_IDs = OrphanFamily::all()->pluck('id')->toArray();
        return [
            'family_id' => fake()->randomElement($families_IDs),
            'name' => fake()->firstName,
            'birth_date'=>fake()->date(),
            'academic_level'=>fake()->randomElement(['غير محدد','ابتدائي','اعدادي','ثانوي','جامعي']),
            'is_supported' => fake()->boolean(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
