<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CampaignController extends Controller
{
    /**
     * Display a listing of the campaigns.
     * @return JsonResponse
     */
    public function index()
    {
        $user = Auth::user();
        $favoriteCampaignIds = $user->favorite->pluck('campaign_id')->toArray();

        $is_donateable_campaigns = Campaign::where('is_donateable', 1)
            ->where('end_date', null)
            ->latest('updated_at')
            ->take(3)
            ->get()
            ->map(function ($campaign) use ($favoriteCampaignIds) {
                $campaign->is_favorite = in_array($campaign->id, $favoriteCampaignIds);
                return $campaign;
            });

        $is_volunteerable_campaigns = Campaign::where('is_volunteerable', 1)
            ->where('end_date', null)
            ->latest()
            ->take(3)
            ->get()
            ->map(function ($campaign) use ($favoriteCampaignIds) {
                $campaign->is_favorite = in_array($campaign->id, $favoriteCampaignIds);
                return $campaign;
            });

        return response()->json([
            'Donateable Campaign' => $is_donateable_campaigns,
            'Volunteerable Campaign' => $is_volunteerable_campaigns
        ], 200);
    }

    /**
     * Display a listing of the Donateable campaigns.
     * @return JsonResponse
     */
    public function donateableCampaign()
    {
        $user = Auth::user();
        $favoriteCampaignIds = $user->favorite->pluck('campaign_id')->toArray();

        $is_donateable_campaigns = Campaign::where('is_donateable', 1)
            ->where('end_date', null)
            ->get()
            ->map(function ($campaign) use ($favoriteCampaignIds) {
                $campaign->is_favorite = in_array($campaign->id, $favoriteCampaignIds);
                return $campaign;
            });
        return response()->json($is_donateable_campaigns, 200);
    }

    /**
     * Display a listing of the volunteerable campaigns.
     * @return JsonResponse
     */
    public function volunteerableCampaign()
    {
        $user = Auth::user();

        // Get the IDs of the user's favorite campaigns
        $favoriteCampaignIds = $user->favorite->pluck('campaign_id')->toArray();

        // Get the volunteerable campaigns and check if they are favorites
        $is_volunteerable_campaigns = Campaign::where('is_volunteerable', 1)
            ->where('end_date', null)
            ->get()
            ->map(function ($campaign) use ($favoriteCampaignIds) {
                $campaign->is_favorite = in_array($campaign->id, $favoriteCampaignIds);
                return $campaign;
            });

        return response()->json($is_volunteerable_campaigns, 200);
    }
    /**
     * Display the specified campaign.
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id)
    {
        $user = Auth::user();
        $campaign = Campaign::findOrfail($id);
        $favoriteCampaignIds = $user->favorite->pluck('campaign_id')->toArray();
        $campaign->is_favorite = in_array($campaign->id, $favoriteCampaignIds);
        return response()->json($campaign, 200);
    }
}
