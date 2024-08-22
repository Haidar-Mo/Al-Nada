<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StatusUpdate>
 */
class StatusUpdateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'statusable_type' => fake()->randomElement([
                //'App\Models\OrphanFamilyChild',
                'App\Models\Student',
                //'App\Models\chasteFamily',
                'App\Models\OldPeople',
            ]),
            'statusable_id' => function (array $attributes) {
                $model = $attributes['statusable_type'];
                return $model::inRandomOrder()->first()->id;
            },
            'description' => fake()->sentence(20)

        ];
    }
}
