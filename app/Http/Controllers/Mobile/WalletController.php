<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletCharge;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{

    /**
     * Display the specified Wallet
     * @return JsonResponse
     */
    public function show(Wallet $wallet)
    {
        $user = User::find(Auth::user()->id);
        $wallet = $user->wallet()->with('billingHistory')->get();
        return response()->json($wallet, 200);
    }

    /**
     * Display List of Wallet billing history
     * @return JsonResponse
     */
    public function billingHistory()
    {
        $user = User::find(Auth::user()->id);
        $billing_history = $user->wallet->billingHistory;
        return response()->json($billing_history, 200);
    }
    /**
     * Send Wallet charge request
     * @param Request $request
     * @return JsonResponse
     */
    public function deposit(Request $request)
    {
        $request->validate([
            'image' => ['image']
        ]);
        $user = User::find(Auth::user()->id);
        if ($request->hasFile('image'))
            $path = $request->file('image')->store('WalletCharge', 'public');
        $charge_request = $user->wallet->charge()->create([
            'image' => $path
        ]);
        return response()->json($charge_request, 200);
    }
}
