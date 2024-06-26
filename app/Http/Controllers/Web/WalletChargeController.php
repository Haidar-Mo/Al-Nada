<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\WalletCharge;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WalletChargeController extends Controller
{
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
    public function accept(string $id)
    {
        $wallet_charge = WalletCharge::findOrFail($id);
        $wallet_charge->update(['status' => 'تم الشحن']);
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
