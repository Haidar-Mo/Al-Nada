<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use App\Models\WalletCharge;
use App\Notifications\NewCampaignNotification;
use App\Traits\NotificationTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class WalletChargeController extends Controller
{
    use NotificationTrait;
    /**
     * Display a listing of the Wallet charge request
     * @return JsonResponse
     */
    public function index()
    {
        $wallet_charge = WalletCharge::with('wallet.user')->get();
        return response()->json($wallet_charge, 200);
    }

    /**
     * Display the specified Wallet charge request.
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id)
    {
        $wallet_charge = WalletCharge::findOrFail($id);
        return response()->json($wallet_charge, 200);
    }

    /**
     * Accept cahrge request and charge the wallet
     * @param string $id
     * @return JsonResponse 
     */
    public function accept(Request $request, string $id)
    {
        $request->validate([
            'amount' => 'required',
        ]);
        $wallet_charge = WalletCharge::findOrFail($id);
        $wallet_charge->update(['status' => 'تم الشحن']);
        $wallet = Wallet::findOrFail($wallet_charge->wallet_id);
        $user = $wallet->user;
        $bill = $wallet_charge->billingHistory()->create([
            'wallet_id' => $wallet->id,
            'amount' => $request->amount,
            'transiction_type' => 'ايداع'
        ]);
        $wallet->balance += $request->amount;
        $wallet->save();

        ////Notification::send($user, new NewCampaignNotification($bill));
        //$this->sendNotification($user->deviceToken, "محفظة الندى", "تم شحن محفظتك بمبلغ" . $request->amount);

        return response()->json($wallet_charge, 200);
    }

    /**
     * Reject charge request
     * @param string $id
     * @return JsonResponse
     */
    public function reject(string $id)
    {
        $wallet_charge = WalletCharge::findOrFail($id);
        $wallet_charge->update(['status' => 'ملغي']);

        //$this->sendNotification($user->deviceToken, "محفظة الندى", "عذراً لم يتم قبول طلب شحن المحفظة... راجع الجمعية");
        return response()->json($wallet_charge, 200);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WalletCharge $walletCharge)
    {
        //
    }
}
