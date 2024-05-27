<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Campaign;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $is_donateable_campaigns = Campaign::where('is_donateable', 1)->where('end_date', '0000-00-00')->get();
        $is_volunteerable_campaigns = Campaign::where('is_volunteerable', 1)->where('end_date', '0000-00-00')->get();

        return response()->json(['Donateable Campaign' => $is_donateable_campaigns, 'Volunteerable Campaign' => $is_volunteerable_campaigns], 200);
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
    public function show(Campaign $campaign)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Campaign $campaign)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Campaign $campaign)
    {
        //
    }
}
