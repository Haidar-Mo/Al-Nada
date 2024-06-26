<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class DonationService.
 */
class DonationService
{
    public function donate(User $user, Request $request)
    {
        DB::beginTransaction();
        try {
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

            $donation = $user->wallet->donation()->create($request->all());
            if ($request->type == 'مالي' && $request->deliver_type == 'الكتروني') {
                $bill = $donation->bill()->create([
                    'wallet_id' => $user->wallet->id,
                    'transaction_type' => 'سحب',
                    'amount' => $donation->amount,
                ]);
            }
            DB::commit();
            return $donation;
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json($e->getMessage(), 400);
        }
    }
}
