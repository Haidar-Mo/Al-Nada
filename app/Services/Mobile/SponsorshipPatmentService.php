<?php

namespace App\Services\Mobile;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class SponsorshipPatment.
 */
class SponsorshipPatmentService
{

    protected $payment;

    public function __construct($payment)
    {
        $this->payment = $payment;
    }

    public function pay(Request $request)
    {
        DB::beginTransaction();
        $user = $this->payment->user;
        try {

            if ($this->payment->paid != '0')
                return ['message' => 'you cant pay to this month', 'code' => 422];

            if ($request['amount'] > $user->wallet->balance)
                return ['message' => 'Your balance is not enough to donate', 'code' => 422];

            if ($request['amount'] < $this->payment->case->sponsorshipable->min_sponsorship_payment)
                return ['message' => 'You can`t pay less than the minimum bail', 'code' => 422];


            $this->payment->update([
                'amount' => $request->amount,
                'paid' => '1',
                'payment_date' => now(),
            ]);
            $user->wallet->decrement('balance', $request['amount']);
            DB::commit();
            return ['message' => $this->payment, 'code' => 200];
        } catch (\Exception $e) {
            DB::rollBack();
            return ['message' => $e->getMessage(), 'code' => 400];
        }
    }
}
