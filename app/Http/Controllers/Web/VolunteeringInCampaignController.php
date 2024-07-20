<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\VolunteerInCampaign;
use App\Models\VolunteeringInCampaign;
use Illuminate\Http\Request;

class VolunteeringInCampaignController extends Controller
{
    /**
     * Display a listing of the Volunteering  Requests
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 20);
        $orderBy = $request->input('order_by', 'id');
        $order = $request->input('order', 'asc');
        $requests = VolunteeringInCampaign::with('city')->orderBy($orderBy, $order)->paginate($perPage);
        return response()->json($requests, 200);
    }

    /**
     * Display the specified Volunteering Request
     * @param string $id
     */
    public function show(string $id)
    {
        $request = VolunteeringInCampaign::with('city')->findOrFail($id);
        return response()->json($request, 200);
    }

    /**
     * Accept volunteering request
     * @param string $id
     * @return JsonResponse
     */
    public function accept(string $id)
    {
        $volunteer_request = VolunteeringInCampaign::find($id);
        if ($volunteer_request->status != 'انتظار')
            return response()->json(['message' => 'الطلب معالج بالفعل'], 422);
        $volunteer_request->update([
            'rejecting_reason' => null,
            'status' => 'مقبول'
        ]);
        $volunteer = $volunteer_request->volunteer()->create($volunteer_request->all());
        return response()->json($volunteer, 200);
    }

    /**
     * Reject volunteering request
     * @param string $id
     * @return JsonResponse
     */
    public function reject(Request $request, string $id)
    {
        $request->validate(['rejecting_reason' => ['required', 'string']]);
        $volunteer_request = VolunteeringInCampaign::find($id);
        if ($volunteer_request->status != 'انتظار')
            return response()->json(['message' => 'الطلب معالج بالفعل'], 422);
        $volunteer_request->update([
            'rejecting_reason' => $request->rejecting_reason,
            'status' => 'مرفوض'
        ]);
        return response()->json($volunteer_request, 200);
    }

    /**
     * Remove the specified Volunteering  Request from storage.
     * @param string $id
     */
    public function destroy(string $id)
    {
        $request = VolunteeringInCampaign::findOrFail($id);
        $request->delete();
        return response()->json(null, 204);
    }
}
