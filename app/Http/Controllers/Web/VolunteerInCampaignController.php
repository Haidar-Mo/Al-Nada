<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\VolunteerInCampaignRequest;
use App\Models\VolunteerInCampaign;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VolunteerInCampaignController extends Controller
{
    /**
     * Display a listing of the Campaign's Volunteers
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 20);
        $orderBy = $request->input('order_by', 'id');
        $order = $request->input('order', 'asc');
        $filter = $request->input('filter', 'id');
        $search  = $request->input('search');

        $campaigns = VolunteerInCampaign::with(['request', 'campaign', 'city'])
            ->where($filter, 'LIKE', "%{$search}%")
            ->orderBy($orderBy, $order)
            ->paginate($perPage);
        return response()->json($campaigns);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VolunteerInCampaignRequest $request)
    {
        $volunteer = VolunteerInCampaign::create($request->all());
        $volunteer->load(['request', 'campaign', 'city']);
        return response()->json($volunteer, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $volunteer = VolunteerInCampaign::with(['request', 'campaign', 'city'])->findOrFail($id);
        return response()->json($volunteer, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VolunteerInCampaignRequest $request, string $id)
    {
        $volunteer = VolunteerInCampaign::with(['request', 'campaign', 'city'])->findOrFail($id);
        $volunteer->update($request->all());
        return response()->json($volunteer, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $volunteer = VolunteerInCampaign::with(['request', 'campaign', 'city'])->findOrFail($id);
        $volunteer->delete();
        return response()->json(null, 204);
    }
}
