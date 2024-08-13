<?php

namespace App\Services\Mobile;

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

            // Handle financial donation
            if ($request['type'] === 'مالي') {
                if (!isset($request['amount'])) {
                    return ['message' => 'المبلغ مطلوب للتبرع المالي', 'code' => 422];
                }

                if ($request['amount'] < $campaign->min_limit_for_donation) {
                    return ['message' => 'المبلغ يجب أن يكون أكبر من الحد الأدنى للتبرع المالي', 'code' => 422];
                }

                if ($request['delivery_type'] === 'الكتروني') {
                    if ($request['amount'] > $user->wallet->balance) {
                        return ['message' => 'رصيدك لا يكفي لعملية التبرع', 'code' => 422];
                    }
                    $request['description'] = null;
                    $request['address'] = null;
                    $request['status'] = 'تم الاستلام';
                    $user->wallet->decrement('balance', $request['amount']);
                } elseif ($request['delivery_type'] === 'مندوب توصيل') {
                    if (!isset($request['address'])) {
                        return ['message' => 'العنوان مطلوب للتبرع عبر مندوب توصيل', 'code' => 422];
                    }
                }
            } else {
                // Handle other types of donations
                if (!isset($request['description'])) {
                    return ['message' => 'وصف التبرع مطلوب', 'code' => 422];
                }
                if (!isset($request['address'])) {
                    return ['message' => 'العنوان مطلوب للتبرع عبر مندوب توصيل', 'code' => 422];
                }
                $request['amount'] = null;
                $request['delivery_type'] = 'مندوب توصيل';
            }

            // Create the donation
            $donationData = array_merge($request->all(), ['campaign_id' => $campaign->id]);
            $donation = $user->donationToCampaign()->create($donationData);

            // Create a bill if necessary
            if ($request['type'] === 'مالي' && $request['delivery_type'] === 'الكتروني') {
                $donation->bill()->create([
                    'wallet_id' => $donation->user->wallet->id,
                    'transaction_type' => 'سحب',
                    'amount' => $request['amount'],
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
