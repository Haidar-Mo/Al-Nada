<?php

namespace Database\Factories;

use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WalletCharge>
 */
class WalletChargeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $wallet_IDs = Wallet::all()->pluck('id')->toArray();
        return [
            'wallet_id' => fake()->randomElement($wallet_IDs),
            'image' => 'WalletCharge/0cqMBuDlZq0m2rVJHc9D2ZstJ9GMzh3iwc7wgqE9.png',
            'status' => 'جديد'
        ];
    }
}
