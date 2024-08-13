<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\DonationRequest;
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
        $user = auth()->user();
        $donations = $user->donationToCampaign()->with('campaign')->latest()->paginate(20);
        $total_donation = strval($donations->where('type', 'مالي')->sum('amount'));
        return response()->json(['donations' => $donations, 'total donations' => $total_donation], 200);
    }

    /**
     * View specific Donation 
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id)
    {
        $user = auth()->user();
        $donation = $user->donationToCampaign()->with('campaign')->findOrFail($id);
        return Response()->json($donation, 200);
    }

    /**
     * Store New Donation to specific campaign in database
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function store(DonationRequest $request, string $id)
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
