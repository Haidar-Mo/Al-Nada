<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\DonationAlert;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonationAlertController extends Controller
{
    /**
     * Display a listing of user's Donation-Alerts.
     * @return JsonResponse
     */
    public function index()
    {
        $user = User::find(Auth::user()->id);
        $alerts = $user->donationAlert;
        return response()->json($alerts, 200);
    }


    /**
     * Store a newly created Donation-Alert in storage.
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required'],
            'frequency' => ['required', 'in:يومي,اسبوعي,شهري']
        ]);
        $user = User::find(Auth::user()->id);
        $alert = $user->donationAlert()->create($request->only('title', 'requency'));
        return response()->json($alert, 201);
    }

    /**
     * Display the specified Donation-Alert.
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id)
    {
        $user = User::find(Auth::user()->id);
        $alert = $user->donationAlert()->findOrFail($id);
        return response()->json($alert, 200);
    }

    /**
     * Update the specified Donation-Alert in storage.
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => ['required'],
            'frequency' => ['required', 'in:يومي,اسبوعي,شهري']
        ]);
        $user = User::find(Auth::user()->id);
        $alert = $user->donationAlert()->findOrFail($id);
        $alert->update($request->only('title', 'frequency'));
        return response()->json($alert, 200);
    }

    /**
     * Remove the specified Donation-Alert from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find(Auth::user()->id);
        $alert = $user->donationAlert()->findOrFail($id);
        $alert->delete();
        return response()->json(null, 204);
    }
}
