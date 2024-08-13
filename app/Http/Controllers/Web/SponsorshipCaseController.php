<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\SponsorshipCase;
use App\Models\StatusUpdate;
use App\Services\Web\AcceptSponsorshipCase;
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
        $case = SponsorshipCase::with(['user', 'sponsorshipable', 'payment'])->findOrFail($id);
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
        $service = new AcceptSponsorshipCase($case);
        $result = $service->handle();
        return response()->json($result, 200);
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
            'reject_reason' => $request->reject_reason,
            'active' => 0
        ]);
        return response()->json($case, 200);
    }

    /**
     * End an Accepted Sponsorship case
     * @param Request $request  end_reason 
     * @param string $id The ID of the case
     * @return JsonRespone
     */
    public function end(Request $request, string $id)
    {
        $request->validate([
            'end_reason' => 'required|string'
        ]);
        $case = SponsorshipCase::findOrFail($id);
        $case->update([
            'active' => 0,
            // 'status'=>'ايقاف',   you need to edit the migration
            'end_reason' => $request->end_reason,
            'end_date' => now()
        ]);
        return response()->json($case, 200);
    }

    public function indexStatusUpdate(string $id)
    {
        $statusUpdates = SponsorshipCase::with('sponsorshipable.statusUpdate')->findOrFail($id)
            ->sponsorshipable
            ->statusUpdate()
            ->latest()
            ->get();
        return response()->json($statusUpdates, 200);
    }
    public function addStatusUpdate(Request $request, string $id)
    {
        $data = $request->validate([
            'description' => ['required', 'string']
        ]);
        $case = SponsorshipCase::findOrFail($id)->sponsorshipable->statusUpdate()->create($data);
        return response()->json($case, 201);
    }


    public function updateStatusUpdate(Request $request, string $id)
    {
        $update = StatusUpdate::findOrFail($id);
        $data = $request->validate([
            'description' => ['required', 'string']
        ]);
        $update->update($data);
        return response()->json($update, 200);
    }

    public function destroyStatusUpdate(string $id)
    {
        $update = StatusUpdate::findOrFail($id);
        $update->delete();
        return response()->json(null, 204);
    }
}
