<?php

namespace Database\Factories;

use App\Models\Donation;
use App\Models\DonationCampaign;
use App\Models\Wallet;
use App\Models\WalletCharge;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BillingHistory>
 */
class BillingHistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $wallet_IDs = Wallet::all()->pluck('id')->toArray();
        $billable_type = $this->faker->randomElement([WalletCharge::class, Donation::class, DonationCampaign::class]);
        $billable_id = $billable_type::factory()->create();
        return [
            'wallet_id' => fake()->randomElement($wallet_IDs),
            'billable_type' => $billable_type,
            'billable_id' => $billable_id,
            'amount' => fake()->randomNumber(7),
            'transaction_type' => fake()->randomElement(['سحب', 'ايداع']),
        ];
    }
}
