<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Administration;
use App\Models\User;
use App\Notifications\SendDonationToCampaignNotification;
use App\Services\Mobile\DonationToCampaignService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class DonationToCampaignController extends Controller
{
    /**
     * Display list of user Donations for Campaign
     * @return JsonResponse
     */
    public function index()
    {
        $user = User::find(Auth::id());
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
        $user = User::find(Auth::id());
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
        $user = User::find(Auth::id());
        $donation_service = new DonationToCampaignService;
        $response = $donation_service->donate($user, $request, $id);

        // Send Notification : 
        if ($response['code'] === 201) {
            $employee = Administration::all();
            Notification::send($employee, new SendDonationToCampaignNotification($response['message']));
        }
        return response()->json(['message' => $response['message']], $response['code']);
    }
}
