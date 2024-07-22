<?php

namespace Database\Factories;

use App\Models\Campaign;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VolunteerCampaign>
 */
class VolunteerCampaignFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $campaign_IDs = Campaign::all()->pluck('id')->toArray();
        return [
            'campaign_id' => fake()->randomElement($campaign_IDs),
            'first_name' => fake()->name(),
            'last_name' => fake()->name(),
            'phone_number' => fake()->phoneNumber(),
            'academic_level' => fake()->randomElement(['غير محدد', 'ابتدائي', 'اعدادي', 'ثانوي', 'جامعي']),
            'city_id' => 1,
            'address' => fake()->address(),
            'active' => 1,
            'start_date' => Carbon::now()
        ];
    }
}
