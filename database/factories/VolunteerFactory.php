<?php

namespace Database\Factories;

use App\Models\Volunteering;
use Carbon\Carbon;
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
        $request = Volunteering::factory()->create();
        return [
            'request_id' => $request->id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'birth_date' => $request->birth_date,
            'phone_number' => $request->phone_number,
            'academic_level' => fake()->randomElement(['غير محدد', 'ابتدائي', 'اعدادي', 'ثانوي', 'جامعي']),
            'city_id' => 1,
            'address' => $request->address,
            'active' => 1,
            'rate' => fake()->randomFloat(null, 0.1, 5.0)
        ];
    }
}
