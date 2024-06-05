<?php

namespace App\Services;

use App\Models\{Donation, User};
use Illuminate\Http\Request;

/**
 * Class DonationService.
 */
class DonationService
{
    public function donate(User $user, Request $request)
    {
        $request->validate([
            'type' => ['required', 'string'],
        ]);

        if ($request->type === 'مالي') {
            $request->validate([
                'amount' => 'required|numeric|min:0.01',
            ]);


            if ($request->amount > $user->wallet->balance) {
                return response()->json(['message' => 'رصيدك لا يكفي لعملية التبرع'], 422);
            }

            $user->wallet->decrement('balance', $request->amount);
        } else {
            $request->validate([
                'description' => 'required|string',
            ]);
        }

        $donation = $user->donation()->create($request->all());

        return $donation;
    }
}
