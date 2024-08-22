<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\SponsorshipCase;
use App\Services\Mobile\SponsorshipPaymentService;
use Illuminate\Http\Request;

class SponsorshipCaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $cases = $user->sponsorshipCase()->with('sponsorshipable')->where('active', 1)->get();
        return response()->json($cases, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = auth()->user();
        $case = $user->sponsorshipCase()->with(['sponsorshipable' => function ($query) {
            $query->with('statusUpdate');
        }])->find($id);

        return response()->json($case, 200);
    }


    public function listStatusUpdate(string $id)
    {
        $case = SponsorshipCase::findOrfail($id);
        $status = $case->sponsorshipable->statusUpdate()->latest()->get();
        return response()->json($status, 200);
    }

    public function lastStatusUpdate(SponsorshipCase $case)
    {
        //$case = SponsorshipCase::findOrFail($id);
        $status = $case->sponsorshipable->statusUpdate()->latest()->first();
        return response()->json($status, 200);
    }

    public function lastYearPayment(string $id)
    {
        $user = auth()->user();
        $case = $user->sponsorshipCase()->findOrFail($id);
        $payment = $case->payment()
            ->latest()
            ->take(12)
            ->orderBy('payment_month')
            ->get();
        return response()->json($payment, 200);
    }

    public function payment(Request $request, string $id)
    {
        $user = auth()->user();
        $payment = $user->sponsorshipPayment()->findOrFail($id);
        $case = $payment->case;

        // get the last 12 month ( last year )
        $year_payment = $case->payment()
            ->latest()
            ->take(12)
            ->orderBy('payment_month')
            ->get();

        // check if the current payment is the first payment of the year (unpaid)
        $currentIndex = $year_payment->search(function ($year_payment) use ($id) {
            return $year_payment->id == $id;
        });
        $hasUnpaidBefore = $year_payment->slice(0, $currentIndex)->contains('paid', 0);
        if ($hasUnpaidBefore) {
            return response()->json(['message' => 'Cannot pay because there are unpaid previous payments.'], 400);
        }

        $service = new SponsorshipPaymentService($payment);
        $resault =  $service->pay($request);
        return response()->json($resault['message'], $resault['code']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SponsorshipCase $sponsorshipCase)
    {
        //
    }
}
