<?php

namespace App\Services\Web;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Class AcceptSponsorshipCase.
 */
class AcceptSponsorshipCase
{
    protected $case;
    /**
     * Create a new Service instance.
     */
    public function __construct($case)
    {
        $this->case = $case;
    }

    public function handle()
    {
        DB::beginTransaction();
        try {
            $this->case->update([
                'status' => 'مقبول',
                'start_date' => now(),
                'active' => 1
            ]);

            $currentYear = Carbon::now()->year;

            // Loop through each month in the current year
            for ($month = 1; $month <= 12; $month++) {

                $paymentMonth = Carbon::create($currentYear, $month, 1);
                $paid = $paymentMonth->isPast() ? '2' : '0';

                $this->case->payment()->create([
                    'user_id' => $this->case->user_id,
                    'payment_month' => $paymentMonth,
                    'paid' => $paid,
                ]);
            }
            DB::commit();
            return $this->case;
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json($e->getMessage(), 400);
        }
    }
}
