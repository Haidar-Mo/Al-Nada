<?php

namespace App\Services;

use App\Models\Campaign;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class DonationToCampaignService.
 */
class DonationToCampaignService
{
    public function donate(User $user, Request $request, string $id)
    {
        DB::beginTransaction();
        try {
            // Find the Campaign
            $campaign = Campaign::findOrFail($id);

            // Check if the campaign is open for donations
            if (!$campaign->is_donateable) {
                return ['message' => 'لايمكنك التبرع لهذه الحملة الآن', 'code' => 422];
            }

            // Validate type of donation
            $validatedData = $request->validate([
                'type' => 'required|string',
                'amount' => 'nullable|numeric|min:0.01',
                'delivery_type' => 'nullable|string|in:الكتروني,مندوب توصيل',
                'address' => 'nullable|string',
                'description' => 'nullable|string',
            ]);

            // Handle financial donation
            if ($validatedData['type'] === 'مالي') {
                if (!isset($validatedData['amount'])) {
                    return ['message' => 'المبلغ مطلوب للتبرع المالي', 'code' => 422];
                }

                if ($validatedData['amount'] < $campaign->min_limit_for_donation) {
                    return ['message' => 'المبلغ يجب أن يكون أكبر من الحد الأدنى للتبرع المالي', 'code' => 422];
                }

                if ($validatedData['delivery_type'] === 'الكتروني') {
                    if ($validatedData['amount'] > $user->wallet->balance) {
                        return ['message' => 'رصيدك لا يكفي لعملية التبرع', 'code' => 422];
                    }
                    $validatedData['description'] = null;
                    $validatedData['address'] = null;
                    $validatedData['status'] = 'تم الاستلام';
                    $user->wallet->decrement('balance', $validatedData['amount']);
                } elseif ($validatedData['delivery_type'] === 'مندوب توصيل') {
                    if (!isset($validatedData['address'])) {
                        return ['message' => 'العنوان مطلوب للتبرع عبر مندوب توصيل', 'code' => 422];
                    }
                }
            } else {
                // Handle other types of donations
                if (!isset($validatedData['description'])) {
                    return ['message' => 'وصف التبرع مطلوب', 'code' => 422];
                }
                if (!isset($validatedData['address'])) {
                    return ['message' => 'العنوان مطلوب للتبرع عبر مندوب توصيل', 'code' => 422];
                }
                $validatedData['amount'] = null;
                $validatedData['delivery_type'] = 'مندوب توصيل';
            }

            // Create the donation
            $donationData = array_merge($validatedData, ['campaign_id' => $campaign->id]);
            $donation = $user->donationCampaign()->create($donationData);

            // Create a bill if necessary
            if ($validatedData['type'] === 'مالي' && $validatedData['delivery_type'] === 'الكتروني') {
                $donation->bill()->create([
                    'wallet_id' => $donation->user->wallet->id,
                    'transaction_type' => 'سحب',
                    'amount' => $validatedData['amount'],
                ]);
            }
            DB::commit();
            return ['message' => $donation, 'code' => 201];
        } catch (\Exception $e) {
            DB::rollBack();
            return ['message' => $e->getMessage(), 'code' => 400];
        }
    }
}
