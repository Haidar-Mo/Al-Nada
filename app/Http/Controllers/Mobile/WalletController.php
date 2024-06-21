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
        $wallet = $user->wallet;
        return response()->json($wallet, 200);
    }

/**
 * Charge Wallet
 * @param Request $request
 * @return JsonResponse
 */
    public function charge(Request $request){

        $request->validate([
            'image'=>['image']
        ]);
        $user = User::find(Auth::user()->id);
        $user->wallet->charge->create();
    }
}
