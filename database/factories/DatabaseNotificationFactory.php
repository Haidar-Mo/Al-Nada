<?php

namespace Database\Factories;

use App\Models\Administration;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification>
 */
class DatabaseNotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => Str::uuid()->toString(),
            'type' => fake()->randomElement([
                'App\Models\DonationToCampaign',
                'App\Models\Donation',
                'App\Models\WalletCharge',
                'App\Models\Order',
                'App\Models\VolunteeringRequest',
                'App\Models\VolunteeringInCampaignRequest'
            ]),
            'notifiable_type' => 'App\Models\Administration',
            'notifiable_id' => Administration::inRandomOrder()->first()->id,
            'data' => [
                'message' => 'Fake notification number :' . fake()->randomNumber(3),
                'model_id' => function (array $attributes) {
                    $model = $attributes['type'];
                    return $model::inRandomOrder()->first()->id;
                }
            ],
            'read_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
