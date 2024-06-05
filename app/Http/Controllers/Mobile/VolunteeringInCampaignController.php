<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\VolunteeringInCampaignRequest;
use App\Models\Campaign;
use App\Models\User;
use App\Models\VolunteeringInCampaign;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VolunteeringInCampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $volunteering_request_in_campaign = $user->volunteeringInCampaign;
        return response()->json($volunteering_request_in_campaign, 200);
    }

    /**
     * Store a newly created campain_volunteering in storage.
     * @param VolunteeringInCampaignRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function store(VolunteeringInCampaignRequest $request, string $id)
    {
        $user = User::findOrfail(Auth::user()->id);
        $campaign = Campaign::findOrfail($id);
        if ($campaign->is_volunteerable == 0)
            return response()->json(['message' => 'لايمكنك الإنضمام لهذه الحملة حالباً'], 422);
        $volunteering_request =  $user->volunteeringInCampaign()->create(array_merge(['first_name' => $user->first_name, 'last_name' => $user->last_name, 'city_id' => $user->city_id, 'campaign_id' => $campaign->id], $request->all()));
        return response()->json($volunteering_request, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $volunteering_request_in_campaign = VolunteeringInCampaign::findOrFail($id);
        return response()->json($volunteering_request_in_campaign, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VolunteeringInCampaignRequest $request, string $id)
    {
        $volunteering_request = VolunteeringInCampaign::findOrfail($id);
        if ($volunteering_request->user_id != Auth::user()->id)
            return response()->json(['message' => 'Unauthorized'], 401);
        if ($volunteering_request->status != 'انتظار')
            return response()->json(['message' => 'لايمكنك التعديل على معلومات الطلب'], 422);
        $volunteering_request->update($request->all());
        return response()->json($volunteering_request, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrfail(Auth::user()->id);
        $volunteering_request = VolunteeringInCampaign::findOrfail($id);
        if ($volunteering_request->status != 'انتظار')
            return response()->json(['message' => 'عذراً, لايمكنك الغاء الطلب'], 422);
        $volunteering_request->delete();
        return response()->json(null, 200);
    }
}
