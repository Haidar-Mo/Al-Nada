<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\VolunteeringInCampaignRequest;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VolunteerCampaign>
 */
class VolunteerInCampaignFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $request = VolunteeringInCampaignRequest::factory()->create();
        return [
            'campaign_id' => $request->campaign_id,
            'request_id' => $request->id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone_number' => $request->phone_number,
            'academic_level' => fake()->randomElement(['غير محدد', 'ابتدائي', 'اعدادي', 'ثانوي', 'جامعي']),
            'city_id' => 1,
            'address' => fake()->address(),
            'active' => 1,
        ];
    }
}
