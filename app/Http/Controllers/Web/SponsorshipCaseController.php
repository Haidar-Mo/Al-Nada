<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\SponsorshipCase;
use Illuminate\Http\Request;

class SponsorshipCaseController extends Controller
{
    /**
     * List all Sponsorship cases
     * @return JsonRespone
     */
    public function index()
    {

        $cases = SponsorshipCase::with(['user', 'sponsorshipable'])->paginate();
        return response()->json($cases, 200);
    }

    /**
     * View a Sponsorship case details
     * @param string $id The ID of the case
     * @return JsonRespone
     */
    public function show(string $id)
    {
        $case = SponsorshipCase::with(['user', 'sponsorshipable'])->findOrFail($id);
        return response()->json($case, 200);
    }

    /**
     * Accepted a Sponsorship case
     * @param string $id The ID of the case
     * @return JsonRespone
     */
    public function accept(string $id)
    {
        $case = SponsorshipCase::findOrFail($id);
        $case->update([
            'status' => 'مقبول',
            'active' => 1
        ]);
        return response()->json($case, 200);
    }

    /**
     * Reject a Sponsorship case
     * @param Request $request  reject_reason 
     * @param string $id The ID of the case
     * @return JsonRespone
     */
    public function reject(Request $request, string $id)
    {
        $request->validate([
            'reject_reason' => 'required|string'
        ]);
        $case = SponsorshipCase::findOrFail($id);
        $case->update([
            'status' => 'مرفوض',
            'reject_reason' => $request->rejec_reson,
            'active' => 0
        ]);
        return response()->json($case, 200);
    }

    /**
     * Stop an Accepted Sponsorship case
     * @param Request $request  end_reason 
     * @param string $id The ID of the case
     * @return JsonRespone
     */
    public function stop(Request $request, string $id)
    {
        $request->validate([
            'end_reason' => 'required|string'
        ]);
        $case = SponsorshipCase::findOrFail($id);
        $case->update([
            'active' => 0,
            'end_reason' => $request->end_reason
        ]);
        return response()->json($case, 200);
    }
}
