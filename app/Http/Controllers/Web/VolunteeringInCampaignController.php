<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\VolunteerInCampaign;
use App\Models\VolunteeringInCampaign;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $requests = VolunteeringInCampaign::with('city','campaign')->orderBy($orderBy, $order)->paginate($perPage);
        return response()->json($requests, 200);
    }

    /**
     * Display the specified Volunteering Request
     * @param string $id
     */
    public function show(string $id)
    {
        $request = VolunteeringInCampaign::with('city','campaign')->findOrFail($id);
        return response()->json($request, 200);
    }

    /**
     * Accept volunteering request
     * @param string $id
     * @return JsonResponse
     */
    public function accept(string $id)
    {
        DB::beginTransaction();
        try {
            $volunteer_request = VolunteeringInCampaign::find($id);
            if ($volunteer_request->status != 'انتظار')
                return response()->json(['message' => 'the request is already done'], 422);
            if ($volunteer_request->user->is_volunteer)
                return response()->json(['message' => 'this user is alreade a Volunteer'], 422);
            $volunteer_request->update([
                'rejecting_reason' => null,
                'status' => 'مقبول'
            ]);
            $volunteer = $volunteer_request->volunteer()->create([
                'request_id' => $volunteer_request->id,
                'campaign_id' => $volunteer_request->campaign_id,
                'first_name' => $volunteer_request->first_name,
                'last_name' => $volunteer_request->last_name,
                'phone_number' => $volunteer_request->phone_number,
                'acadimic_level' => $volunteer_request->academic_level,
                'city_id' => $volunteer_request->city_id,
                'address' => $volunteer_request->address,
            ]);
            DB::commit();
            $volunteer->load('city','campaign');
            return response()->json($volunteer, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return  response()->json($e->getMessage(), 400);
        }
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
        $volunteer_request->load('campaign','city');
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
