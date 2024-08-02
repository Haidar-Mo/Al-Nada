<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\DonationToCampaign;
use App\Traits\NotificationTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DonationToCampaignController extends Controller
{
    use NotificationTrait;
    /**
     * Display a listing of the Donation
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 20);
        $orderBy = $request->input('order_by', 'id');
        $order = $request->input('order', 'asc');
        $filter = $request->input('filter', 'id');
        $search  = $request->input('search');

        $donations = DonationToCampaign::with('user')
            ->where($filter, 'LIKE', '%' . $search . '%')
            ->orderBy($orderBy, $order)
            ->paginate($perPage);
        return response()->json($donations, 200);
    }

    /**
     * Display the specified Donation
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id)
    {
        $donation = DonationToCampaign::with('user')->findOrFail($id);
        return response()->json($donation, 200);
    }

    /**
     * Accept the specified donation
     */
    public function accept(string $id)
    {
        $donation = DonationToCampaign::with('user')->findOrFail($id);
        if ($donation->status != 'جديد')
            return response()->json(['message' => 'الطلب معالج بالفعل'], 422);
        $donation->update(['status' => 'تم الاستلام']);
        $user = $donation->user;
        $this->sendNotification($user->deviceToken, 'شكراً لك', 'تم استلام تبرعك :)');
        return response()->json($donation, 200);
    }

    /**
     * Reject the specified donation
     * @param string $id
     * @return JsonResponse
     */
    public function reject(Request $request, string $id)
    {
        $donation = DonationToCampaign::with('user')->findOrFail($id);
        if ($donation->status != 'جديد')
            return response()->json(['message' => 'الطلب معالج بالفعل'], 422);
        $donation->update([
            'status' => 'مرفوض',
            'reject_reason' => $request->reject_reason
        ]);
        $user = $donation->user;
        $this->sendNotification($user->deviceToken, 'تبرع مرفوض', 'عذراً تم رفض تبرعك');
        return response()->json($donation, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
