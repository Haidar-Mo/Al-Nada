<?php

namespace App\Services\Mobile;

use App\Http\Requests\Mobile\DonationRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class DonationService.
 */
class DonationService
{
    public function donate(User $user, Request $request)
    {
        DB::beginTransaction();
        try {

            if ($request['type'] === 'مالي') {
                if (!isset($request['amount'])) {
                    return ['message' => 'المبلغ مطلوب للتبرع المالي', 'code' => 422];
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
                if (!isset($request['description'])) {
                    return ['message' => 'وصف التبرع مطلوب', 'code' => 422];
                }
                if (!isset($request['address'])) {
                    return ['message' => 'العنوان مطلوب للتبرع عبر مندوب توصيل', 'code' => 422];
                }
                $request['amount'] = null;
                $request['delivery_type'] = 'مندوب توصيل';
            }

            $donation = $user->donation()->create($request->all());
            if ($request['type'] === 'مالي' && $request['delivery_type'] === 'الكتروني') {
                $donation->bill()->create([
                    'wallet_id' => $user->wallet->id,
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
