<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    /**
     * Display a listing of the campaigns.
     * @return JsonResponse
     */
    public function index()
    {
        $is_donateable_campaigns = Campaign::where('is_donateable', 1)->where('end_date', null)->latest()->take(3)->get();
        $is_volunteerable_campaigns = Campaign::where('is_volunteerable', 1)->where('end_date', null)->latest()->take(3)->get();

        return response()->json(['Donateable Campaign' => $is_donateable_campaigns, 'Volunteerable Campaign' => $is_volunteerable_campaigns], 200);
    }

    public function donateableCampaign(){
        $is_donateable_campaigns = Campaign::where('is_donateable', 1)->where('end_date', null)->get();
        return response()->json($is_donateable_campaigns, 200);
    }


    public function volunteerableCampaign(){
        $is_volunteerable_campaigns = Campaign::where('is_volunteerable', 1)->where('end_date', null)->get();
        return response()->json($is_volunteerable_campaigns, 200);
    }
    /**
     * Display the specified campaign.
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id)
    {
        $campaign = Campaign::findOrfail($id);
        return response()->json($campaign, 200);
    }
}
