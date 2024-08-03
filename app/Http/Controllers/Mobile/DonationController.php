<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\DonationRequest;
use App\Models\Administration;
use App\Models\User;
use App\Notifications\SendDonationNotification;
use App\Services\Mobile\DonationService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class DonationController extends Controller
{

    /**
     * Display list of user Donations
     * @return JsonResponse
     */
    public function index()
    {
        $user = auth()->user();

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
        $user = auth()->user();
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
        $user = auth()->user();
        $service = new DonationService;
        $response = $service->donate($user, $request);

        // Send Notiication to Dashboard
        if ($response['code'] === 201) {
            $employee = Administration::all();
            Notification::send($employee, new SendDonationNotification($response['message']));
        }
        return response()->json(['message' => $response['message']], $response['code']);
    }

    public function update(DonationRequest $request, string $id)
    {
        $user = auth()->user();
        $donation = auth()->user()->donation()->findOrFail($id);
        if ($donation->status != 'جديد')
            return response()->json(['message' => 'لايمكنك التعديل على هذا الطلب'], 422);
        $donation->update($request->all());
        return response()->json($donation, 200);
    }

    public function destroy(string $id)
    {
        $user = User::find(Auth::id());
        $donation = $user->donation()->findOrFail($id);
        if ($donation->status != 'جديد')
            return response()->json(['message' => 'لايمكنك الغاء هذا الطلب'], 422);
        $donation->delete();
        // delete notification
        return response()->json(['message' => 'تم الغاء الطلب '], 200);
    }
}
