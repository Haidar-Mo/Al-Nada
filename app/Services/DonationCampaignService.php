<?php

namespace App\Services;

use App\Models\Campaign;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Class DonationCampaignService.
 */
class DonationCampaignService
{
    public function donate(User $user, Request $request, string $id)
    {
        $request->validate([
            'type' => ['required', 'string'],
        ]);

        if ($request->type === 'مالي') {
            $request->validate([
                'amount' => 'required|numeric|min:0.01',
            ]);


            if ($request->amount > $user->wallet->balance) {
                return response()->json(['message' => 'رصيدك لا يكفي لعملية التبرع'], 422);
            }

            $user->wallet->decrement('balance', $request->amount);
        } else {
            $request->validate([
                'description' => 'required|string',
            ]);
        }
        $campaign = Campaign::findOrFail($id);
        if ($campaign->is_donateable == 0)
            return response()->json(['message' => 'لايمكنك التبرع لهذه الحملة الآن'], 422);
       
            $donation = $user->donationCampaign()->create(array_merge($request->all(), ['campaign_id' => $campaign->id]));

        return $donation;
    }
}
