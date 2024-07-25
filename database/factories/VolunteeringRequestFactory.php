<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VolunteeringRequest>
 */
class VolunteeringRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user_IDs = User::all()->pluck('id')->toArray();
        $user = User::find(fake()->randomElement($user_IDs));
        return [
            'user_id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'father_name' => fake()->firstNameMale(),
            'mother_name' => fake()->firstNameFemale(),
            'birth_date' => $user->birth_date,
            'social_situation' => fake()->randomElement(['أعزب', 'متزوج', 'مطلق', 'أرمل']),
            'partner_name' => fake()->name(),
            'phone_number' => $user->phone_number,
            'fixed_phone_number' => fake()->phoneNumber(),
            'user_work' => fake()->jobTitle(),
            'father_work' => fake()->jobTitle(),
            'mother_work' => fake()->jobTitle(),
            'partner_work' => fake()->jobTitle(),
            'number_of_sons' => '2',
            'birth_date_of_sons' => '{"0":"2010-05-10", "1":"2015-05-10"}',
            'number_of_daughters' => '2',
            'birth_date_of_daughters' => '{"0":"2010-05-10", "1":"2015-05-10"}',
            'city_id' => 1,
            'address' => fake()->address(),
            'languages' => fake()->words(3, true), // Generate 3 words as a comma-separated string
            'assistance_can_be_provided' => fake()->sentence(),
            'academic_level' => fake()->randomElement(['غير محدد', 'ابتدائي', 'اعدادي', 'ثانوي', 'جامعي']),
            'computer_useability_level' => fake()->randomElement(['مبتدأ', 'متوسط', 'متقدم']),
            'old_experience' => fake()->sentence(),
            'hopies' => fake()->words(3, true), // Generate 3 words as a comma-separated string
            'recognation_way' => fake()->sentence(),
            'joining_reason' => fake()->sentence(),
            'old_association' => fake()->company(),
            'job_in_old_association' => fake()->jobTitle(),
            'leave_reason' => fake()->sentence(),
            'id_card_image' => fake()->imageUrl(640, 480, 'people'),
            'personal_image' => fake()->imageUrl(640, 480, 'people'),
            'status' => 'مقبول',
            //'rejecting_reason' => fake()->sentence(),
        ];
    }
}
