<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Administration;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletCharge;
use App\Notifications\WalletCahrgeNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

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
        $path = '';
        $request->validate([
            'image' => ['required', 'image']
        ]);
        $user = User::find(Auth::user()->id);
        if ($request->hasFile('image'))
            $path = $request->file('image')->store('WalletCharge', 'public');
        $charge_request = $user->wallet->charge()->create([
            'image' => $path
        ]);
        $target = Administration::all();
        Notification::send($target, new WalletCahrgeNotification($charge_request));
        return response()->json($charge_request, 200);
    }

    /**
     * Dispaly List of Charge requests
     * @return JsonResponse
     */
    public function listChargeRequests()
    {
        $user = auth()->user();
        $charge_requests = $user->wallet->charge;
        return response()->json($charge_requests, 200);
    }

    /**
     * Display specific charge request
     * @param string $id The ID of the request
     * @return JsonResponse
     */
    public function showChargeRequest(string $id)
    {
        $user = auth()->user();
        $charge_request = $user->wallet->charge()->findOrFail($id);
        return response()->json($charge_request, 200);
    }
}
