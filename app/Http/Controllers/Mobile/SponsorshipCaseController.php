<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\SponsorshipCase;
use App\Models\StatusUpdate;
use App\Services\Mobile\SponsorshipPatmentService;
use Illuminate\Http\Request;

class SponsorshipCaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $cases = $user->sponsorshipCase()->with('sponsorshipable')->where('status', 'مقبول')->get();
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
        $status = $case->sponsorshipable->statusUpdate()->latest();
        return response()->json($status, 200);
    }

    public function lastStatusUpdate(SponsorshipCase $case)
    {
        //$case = SponsorshipCase::findOrFail($id);
        $status = $case->sponsorshipable->statusUpdate()->latest()->first();
        return response()->json($status, 200);
    }

    public function lastPayment(string $id)
    {
        $user = auth()->user();
        $case = $user->sponsorshipCase()->findOrFail($id);
        $payment = $case->payment()->where('paid','1')->latest()->first();
        return response()->json($payment, 200);
    }

    public function payment(Request $request, string $id)
    {
        $user = auth()->user();
        $payment = $user->sponsorshipPayment()->findOrFail($id);
        $service = new SponsorshipPatmentService($payment);
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
