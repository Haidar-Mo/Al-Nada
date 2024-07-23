<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\DonationRequest;
use App\Models\User;
use App\Services\DonationService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class DonationController extends Controller
{
    /**
     * Display list of user Donations
     * @return JsonResponse
     */
    public function index()
    {
        $user = User::find(Auth::user()->id);
        $donations = $user->donation;
        return response()->json($donations, 200);
    }
    /**
     * View specific Donation 
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id)
    {
        $user = User::find(Auth::user()->id);
        $donation = $user->donation()->findOrFail($id);
        return Response()->json($donation, 200);
    }

    /**
     * Store New Donation in database
     * @param DonationRequest $request
     * @return JsonResponse
     */
    public function store(DonationRequest $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        $donation = $user->donation()->create($request->all());
        // notification for dash
        return response()->json($donation, 201);
    }

    public function update(DonationRequest $request, string $id)
    {
        $user = User::find(Auth::user()->id);
        $donation = $user->donation()->findOrFail($id);
        if ($donation->status != 'جديد')
            return response()->json(['message' => 'لايمكنك التعديل على هذا الطلب'], 422);
        $donation->update($request->all());
        return response()->json($donation, 200);
    }

    public function destroy(string $id)
    {
        $user = User::find(Auth::user()->id);
        $donation = $user->donation()->findOrFail($id);
        if ($donation->status != 'جديد')
            return response()->json(['message' => 'لايمكنك الغاء هذا الطلب'], 422);
        $donation->delete();
        // delete notification
        return response()->json(['message'=>'تم الغاء الطلب '],200);
    }
}
