<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Traits\NotificationTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    use NotificationTrait;
    /**
     * Display a listing of the donations
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

        $donations = Donation::with('user')
            ->where($filter, 'LIKE', '%' . $search . '%')
            ->orderBy($orderBy, $order)
            ->paginate($perPage);
        return response()->json($donations, 200);
    }

    /**
     * Display the specified donation
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id)
    {
        $donation = Donation::with('user')->findOrFail($id);
        return response()->json($donation, 200);
    }

    /**
     * Accept the specified donation
     */
    public function accept(string $id)
    {
        $donation = Donation::with('user')->findOrFail($id);
        if ($donation->status != 'جديد')
            return response()->json(['message' => 'الطلب معالج بالفعل'], 422);
        $donation->update(['status' => 'تم الاستلام']);
        $user = $donation->user;
        $this->sendNotification($user->deviceToken, 'شكراً لك', 'تم استلام تبرعك :)');
        return response()->json($donation, 200);
    }

    /**
     * Reject the specified donation
     *@param string $id
     * @return JsonResponse
     */
    public function reject(Request $request, string $id)
    {
        $donation = Donation::with('user')->findOrFail($id);
        if ($donation->status != 'جديد')
            return response()->json(['message' => 'الطلب معالج بالفعل'], 422);
        $donation->update([
            'status' => 'ملغي',
            'reject_reason' => $request->reject_reason,
        ]);
        $user = $donation->user;
        $this->sendNotification($user->deviceToken, 'تبرع مرفوض', 'عذراً تم رفض تبرعك');
        return response()->json($donation, 200);
    }
}
