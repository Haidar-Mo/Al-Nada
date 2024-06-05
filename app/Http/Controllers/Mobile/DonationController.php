<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\User;
use App\Services\DonationService;
use Illuminate\Http\Request;
use App\Services\UserDonationService;
use Google\Rpc\Context\AttributeContext\Response;
use Illuminate\Http\Client\ResponseSequence;
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
        $donation = Donation::where('user_id', Auth::user()->id)->find($id);
        if (!$donation)
            return response()->json(['message' => 'لا يمكنك عرض تفاصيل هذا التبرع'], 422);
        return Response()->json($donation, 200);
    }

    /**
     * Store New Donation in database
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        $donation_service = new DonationService;
        $donation = $donation_service->donate($user, $request);

        return response()->json($donation, 201);
    }
}
