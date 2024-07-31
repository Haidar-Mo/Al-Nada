<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrphanFamily>
 */
class OrphanFamilyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'mother_first_name' => $this->faker->firstNameFemale,
            'mother_last_name' => $this->faker->lastName,
            'mother_birthplace' => $this->faker->city,
            'mother_birthdate' => $this->faker->date('Y-m-d', '2000-01-01'),
            'mother_id_serial_number' => $this->faker->unique()->numerify('ID########'),
            'mother_nationality' => $this->faker->country,
            'phone_number' => $this->faker->unique()->phoneNumber,
            'mother_health_condition' => $this->faker->sentence,
            'mother_academic_level' => $this->faker->randomElement(['غير محدد', 'ابتدائي', 'اعدادي', 'ثانوي', 'جامعي']),
            'family_register_book_number' => $this->faker->unique()->numerify('FRB########'),
            'side_from' => $this->faker->city,
            'father_first_name' => $this->faker->firstNameMale,
            'father_last_name' => $this->faker->lastName,
            'father_nationality' => $this->faker->country,
            'father_death_date' => $this->faker->date('Y-m-d', 'now'),
            'cause_of_death' => $this->faker->sentence,
            'address' => $this->faker->address,
            'house_ownership_type' => $this->faker->randomElement(['ملك', 'إيجار', 'غير ذلك']),
            'residents_number' => $this->faker->numberBetween(1, 10),
            'sons_number' => $this->faker->numberBetween(0, 5),
            'daughter_number' => $this->faker->numberBetween(0, 5),
            'value_rent' => $this->faker->optional()->randomFloat(2, 0, 1000),
            'zip_code' => $this->faker->postcode,
            'supervisor_name' => $this->faker->name,
        ];
    }
}
