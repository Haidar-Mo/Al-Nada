<?php

namespace Database\Factories;

use App\Models\Campaign;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VolunteeringInCampaign>
 */
class VolunteeringInCampaignFactory extends Factory
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
        $campaign_IDs = Campaign::all()->pluck('id')->toArray();
        return [
            'user_id' => $user->id,
            'campaign_id' => fake()->randomElement($campaign_IDs), // Assuming campaign IDs range from 1 to 10
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'phone_number' => $user->phone_number,
            'reason_for_volunteering' => fake()->sentence(),
            'academic_level' => fake()->randomElement(['غير محدد', 'ابتدائي', 'اعدادي', 'ثانوي', 'جامعي']),
            'city_id' => 1, // Assuming city IDs range from 1 to 100
            'address' => fake()->address(),
            'status' => fake()->randomElement(['مقبول', 'مرفوض', 'انتظار']),
        ];
    }
}
