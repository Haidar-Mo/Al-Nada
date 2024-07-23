<?php

namespace Database\Factories;

use App\Models\Campaign;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Favorite>
 */
class FavoriteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $campaign_IDs = Campaign::all()->pluck('id')->toArray();
        $user_IDs = User::all()->pluck('id')->toArray();
        return [
            'campaign_id' => fake()->randomElement($campaign_IDs),
            'user_id' => fake()->randomElement($user_IDs),
        ];
    }
}
