<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\DonationCampaign;
use App\Models\User;
use App\Services\DonationCampaignService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonationCampaignController extends Controller
{
    /**
     * Display list of user Donations for Campaign
     * @return JsonResponse
     */
    public function index()
    {
        $user = User::find(Auth::user()->id);
        $donations = $user->wallet->donationCampaign()->with('campaign')->get();
        return response()->json($donations, 200);
    }

    /**
     * View specific Donation 
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id)
    {
        $user = User::find(Auth::user()->id);
        $donation = $user->wallet->donationCampaign()->with('campaign')->findOrFail($id);
        return Response()->json($donation, 200);
    }

    /**
     * Store New Donation to specific campaign in database
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function store(Request $request, string $id)
    {
        $user = User::findOrFail(Auth::user()->id);
        $donation_service = new DonationCampaignService;
        $donation = $donation_service->donate($user, $request, $id);

        return response()->json($donation, 201);
    }
}
