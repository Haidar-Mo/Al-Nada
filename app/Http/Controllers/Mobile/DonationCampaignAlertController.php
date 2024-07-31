<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\DonationCampaignAlert;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonationCampaignAlertController extends Controller
{
    /**
     * Display a listing of user's Donation-Alerts.
     * @return JsonResponse
     */
    public function index()
    {
        $user = User::find(Auth::id());
        $alerts = $user->donationCampaignAlert()->with('campaign')->get();
        return response()->json($alerts, 200);
    }


    /**
     * Store a newly created Donation-Alert in storage.
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function store(Request $request, string $id)
    {
        $request->validate([
            'title' => ['required'],
            'frequency' => ['required', 'in:يومي,اسبوعي,شهري']
        ]);
        $user = User::find(Auth::id());
        if ($user->donationCampaignAlert()->where('campaign_id', $id)->first())
            return response()->json(['message' => 'هنالك منبه مُضاف لهذه الحملة بالفعل'], 422);
        $campaign = Campaign::findOrFail($id);
        if ($campaign->end_date != null)
            return response()->json(['message' => 'عذراً,الحملة منتهية....إنتظرنا بحملة أخرى <3'], 422);
        $alert = $user->donationCampaignAlert()->create(array_merge($request->only('title', 'requency'), ['campaign_id' => $campaign->id]));
        return response()->json($alert, 201);
    }

    /**
     * Display the specified Donation-Alert.
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id)
    {
        $user = User::find(Auth::id());
        $alert = $user->donationCampaignAlert()->with('campaign')->findOrFail($id);
        return response()->json($alert, 200);
    }

    /**
     * Update the specified Donation-Alert in storage.
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => ['required'],
            'frequency' => ['required', 'in:يومي,اسبوعي,شهري']
        ]);
        $user = User::find(Auth::id());
        $alert = $user->donationCampaignAlert()->findOrFail($id);
        $alert->update($request->only('title', 'frequency'));
        return response()->json($alert, 200);
    }

    /**
     * Remove the specified Donation-Alert from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find(Auth::id());
        $alert = $user->donationcampaignAlert()->findOrFail($id);
        $alert->delete();
        return response()->json(null, 204);
    }
}
