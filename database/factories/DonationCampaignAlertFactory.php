<?php

namespace Database\Factories;

use App\Models\Campaign;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DonationCampaignAlert>
 */
class DonationCampaignAlertFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user_IDs = User::all()->pluck('id')->toArray();
        $campaign_IDs = Campaign::all()->pluck('id')->toArray();
        return [
            'user_id'=>fake()->randomElement($user_IDs),
            'campaign_id'=>fake()->randomElement($campaign_IDs),
            'title' => fake()->text(255),
            'frequency' => fake()->randomElement(['يومي', 'اسبوعي', 'شهري'])
        ];
    }
}
