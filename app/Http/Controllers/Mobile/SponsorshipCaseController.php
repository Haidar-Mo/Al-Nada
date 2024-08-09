<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\SponsorshipCase;
use Illuminate\Http\Request;

class SponsorshipCaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $cases = $user->sponsorshipCases()->with('sponsorshipable')->get();
        return response()->json($cases, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = auth()->user();
        $case = $user->sponsorshipCases()->with(['sponsorshipable', 'payment'])->find($id);
        return response()->json($case, 200);
    }


    public function listStatusUpdate(string $id)
    {
        $case = SponsorshipCase::findOrfail($id);
        $status = $case->sponsorshipable->statusUpdate;
        return response()->json($status, 200);
    }

    public function lastStatusUpdate(string $id)
    {
        $case = SponsorshipCase::findOrFail($id);
        $status = $case->sponsorshipable->statusUpdate()->orderBy('created_at', 'desc')->first();
        return response()->json($status, 200);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SponsorshipCase $sponsorshipCase)
    {
        //
    }
}
