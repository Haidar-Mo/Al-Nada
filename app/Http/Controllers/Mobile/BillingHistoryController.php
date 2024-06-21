<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\BillingHistory;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillingHistoryController extends Controller
{
    /**
     * Display the Bills History of Wallet
     * @return JsonResponse
     */
    public function index()
    {
        $user = User::find(Auth::user()->id);
        $bills = $user->wallet->billingHistory;
        return response()->json($bills);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(BillingHistory $billingHistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BillingHistory $billingHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BillingHistory $billingHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BillingHistory $billingHistory)
    {
        //
    }
}
