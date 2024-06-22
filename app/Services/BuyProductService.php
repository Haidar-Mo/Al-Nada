<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * Class BuyProductService.
 */
class BuyProductService
{

    public function buy(User $user, string $id)
    {
        DB::beginTransaction();
        try {
            $product = Product::findOrFail($id);
            if (!$product->is_available)
                return response()->json(['message' => 'المنتج غير متاح حالياً'], 422);
            $wallet = $user->wallet;
            if ($wallet->balance < $product->price)
                return response()->json(['message' => 'رصيدك لا يكفي لعملية الشؤاء',], 422);

            $wallet->decrement('balance', $product->price);
            $product->sellingHistory()->create([
                'user_id' => $user->id,
                'price'=>$product->price,
            ]);
            $bill = $product->bill()->create([
                'wallet_id' => $user->wallet->id,
                'transaction_type' => 'سحب',
                'amount' => $product->price,
            ]);
            DB::commit();
            return $bill;
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json($e->getMessage(), 400);
        }
    }
}
