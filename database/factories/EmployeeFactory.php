<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Section;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $city_IDs = City::pluck('id');
        $section_IDs = Section::pluck('id');
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'father_name' => $this->faker->firstNameMale,
            'mother_name' => $this->faker->firstNameFemale,
            'phone_number' => $this->faker->unique()->phoneNumber,
            'id_serial_number' => $this->faker->unique()->uuid,
            'nationality' => $this->faker->country,
            'birth_date' => $this->faker->date,
            'city_id' => $this->faker->unique()->randomElement($city_IDs),
            'address' => $this->faker->address(),
            'academic_level' => $this->faker->randomElement(['غير محدد','ابتدائي','اعدادي','ثانوي','جامعي']),
            'academic_specialization' => $this->faker->word,
            'social_situation' => $this->faker->randomElement(['أعزب', 'متزوج', 'مطلق', 'ارمل']),
            'section_id' => fake()->randomElement($section_IDs),
            'date_start_working' => $this->faker->date(),
            'date_end_working' => null,
            'image' => 'Employee/image.png'
        ];
    }
}
