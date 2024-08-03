<?php

namespace App\Services\Mobile;

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
            $validatedData = $request->validate([
                'type' => 'required|string',
                'amount' => 'nullable|numeric|min:0.01',
                'delivery_type' => 'nullable|string|in:الكتروني,مندوب توصيل',
                'address' => 'nullable|string',
                'phone_number'=>'required|string',
                'description' => 'nullable|string',
            ]);

            if ($validatedData['type'] === 'مالي') {
                if (!isset($validatedData['amount'])) {
                    return ['message' => 'المبلغ مطلوب للتبرع المالي', 'code' => 422];
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
                if (!isset($validatedData['description'])) {
                    return ['message' => 'وصف التبرع مطلوب', 'code' => 422];
                }
                if (!isset($validatedData['address'])) {
                    return ['message' => 'العنوان مطلوب للتبرع عبر مندوب توصيل', 'code' => 422];
                }
                $validatedData['amount'] = null;
                $validatedData['delivery_type'] = 'مندوب توصيل';
            }

            $donation = $user->donation()->create($validatedData);
            if ($validatedData['type'] === 'مالي' && $validatedData['delivery_type'] === 'الكتروني') {
                $donation->bill()->create([
                    'wallet_id' => $user->wallet->id,
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
