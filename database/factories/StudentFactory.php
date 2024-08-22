<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'father_name' => $this->faker->firstNameMale,
            'mother_name' => $this->faker->firstNameFemale,
            'birth_date' => $this->faker->date,
            'birth_place' => $this->faker->city,
            'nationality' => $this->faker->country,
            'adress' => $this->faker->address,
            'university' => $this->faker->company,
            'faculty' => $this->faker->word,
            'specialization' => $this->faker->word,
            'study_start_year' => $this->faker->year,
            'expected_graduation_year' => $this->faker->year,
            'actual_graduation_year' => $this->faker->optional()->year,
            'mobile_number' => $this->faker->phoneNumber,
            'landline_number' => $this->faker->optional()->phoneNumber,
            'personal_card_image' => $this->faker->imageUrl(640, 480, 'people', true, 'Faker'),
            'min_sponsorship_payment'=>fake()->randomNumber(5),
            'description' => $this->faker->sentence,
            'is_supported' => 1,
            'visible' => 1,

        ];
    }
}
