<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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

        $is_donateable_campaigns = Campaign::where('is_donateable', 1)
            ->where('end_date', null)
            ->latest()
            ->take(3)
            ->get()
            ->map(function ($campaign) use ($user) {
                $campaign->is_favorite = false;
                $favorites = $user->favorite;
                foreach ($favorites as $favorite) {
                    if ($favorite->campaign->id == $campaign->id) {
                        $campaign->is_favorite = true;
                    }
                }
                return $campaign;
            });

        $is_volunteerable_campaigns = Campaign::where('is_volunteerable', 1)
            ->where('end_date', null)
            ->latest()
            ->take(3)
            ->get()
            ->map(function ($campaign) use ($user) {
                $campaign->is_favorite = false;
                $favorites = $user->favorite;
                foreach ($favorites as $favorite) {
                    if ($favorite->campaign->id == $campaign->id) {
                        $campaign->is_favorite = true;
                    }
                }
                return $campaign;
            });

        return response()->json([
            'Donateable Campaign' => $is_donateable_campaigns,
            'Volunteerable Campaign' => $is_volunteerable_campaigns
        ], 200);
    }

    public function donateableCampaign()
    {
        $user = Auth::user();
        $is_donateable_campaigns = Campaign::where('is_donateable', 1)->where('end_date', null)->get()->map(function ($campaign) use ($user) {
            $campaign->is_favorite = false;
            $favorites = $user->favorite;
            foreach ($favorites as $favorite) {
                if ($favorite->campaign->id == $campaign->id) {
                    $campaign->is_favorite = true;
                }
            }
            return $campaign;
        });
        return response()->json($is_donateable_campaigns, 200);
    }


    public function volunteerableCampaign()
    {
        $user = Auth::user();
        $is_volunteerable_campaigns = Campaign::where('is_volunteerable', 1)->where('end_date', null)->get()->map(function ($campaign) use ($user) {
            $campaign->is_favorite = false;
            $favorites = $user->favorite;
            foreach ($favorites as $favorite) {
                if ($favorite->campaign->id == $campaign->id) {
                    $campaign->is_favorite = true;
                }
            }
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
        $favorites = $user->favorite;
        $campaign->is_favorite = false;
        foreach ($favorites as $favorite) {
            if ($favorite->campaign->id == $campaign->id) {
                $campaign->is_favorite = true;
            }
        }
        return response()->json($campaign, 200);
    }
}
