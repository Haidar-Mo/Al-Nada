<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OldPeople>
 */
class OldPeopleFactory extends Factory
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
            'address' => $this->faker->address,
            'mobile_number' => $this->faker->unique()->phoneNumber,
            'landline_number' => $this->faker->optional()->phoneNumber,
            'social_status' => $this->faker->randomElement(['أعزب', 'متزوج', 'أرمل', 'مطلق']),
            'health_status' => $this->faker->sentence,
            'personal_card_image' => $this->faker->imageUrl(640, 480, 'people', true, 'ID Card'),
            'description' => $this->faker->sentence,
            'min_sponsorship_payment' => fake()->randomNumber(5),
            'is_supported' => 1,
            'visible' => 1,
        ];
    }
}
