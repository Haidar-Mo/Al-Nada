<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DonationController extends Controller
{
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
        $donations = Donation::with('user')->orderBy($orderBy, $order)->paginate($perPage);
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
        $donation->update(['status' => 'تم التسليم']);
        return response()->json($donation, 200);
    }

    /**
     * Reject the specified donation
     *@param string $id
     * @return JsonResponse
     */
    public function reject(string $id)
    {
        $donation = Donation::with('user')->findOrFail($id);
        if ($donation->status != 'جديد')
            return response()->json(['message' => 'الطلب معالج بالفعل'], 422);
        $donation->update(['status' => 'مرفوض']);
        return response()->json($donation, 200);
    }
}
