<?php

namespace Database\Factories;

use App\Models\Campaign;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DonationCampaign>
 */
class DonationCampaignFactory extends Factory
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
            'user_id' => fake()->randomElement($user_IDs),
            'campaign_id' => fake()->randomElement($campaign_IDs),
            'type' => 'مالي',
            'amount' => fake()->randomNumber(7),
            'description' => null,
            'delivery_type' => 'الكتروني',
            'address' => null
        ];
    }
}
