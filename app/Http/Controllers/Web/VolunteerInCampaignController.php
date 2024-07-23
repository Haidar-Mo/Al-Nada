<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\VolunteerInCampaign;
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
        $campaigns = VolunteerInCampaign::with('city')->orderBy($orderBy, $order)->paginate($perPage);
        return response()->json($campaigns);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $volunteerCampaign)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $volunteerCampaign)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $volunteerCampaign)
    {
        //
    }
}
