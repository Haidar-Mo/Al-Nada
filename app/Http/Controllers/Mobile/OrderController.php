<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\order;
use App\Models\User;
use App\Rules\SyrianPhoneNumber;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the order
     * @return JsonResource
     */
    public function index()
    {
        $user = User::find(Auth::user()->id);
        $orders = $user->order()->with('orderable')->get();
        return response()->json($orders, 200);
    }

    /**
     * Display the specified order.
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id)
    {
        $user = User::find(Auth::user()->id);
        $order = $user->order()->with('orderable')->findOrFail($id);
        return response()->json($order, 200);
    }

    /**
     * Update the specified order in storage.
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(Request $request, string $id)
    {
        $user = User::find(Auth::user()->id);
        $data = $request->validate([
            'address' => 'required',
            'phone_number' => ['required', new SyrianPhoneNumber],
            'note' => 'nullable'
        ]);

        $order = $user->order()->with('orderable')->findOrFail($id);
        $order->update($data);
        return response()->json($order, 200);
    }

    /**
     * Remove the specified order from storage
     * @param string $id
     * @return JsonResponse
     */
    public function cancel(string $id)
    {
        $user = User::find(Auth::user()->id);
        $order = $user->order()->with('orderable')->findorFail($id);
        if ($order->status != 'جديد')
            return response()->json(['message' => 'لايمكنك إلغاء هذا الطلب'], 422);
        $order->delete();
        return response()->json(['message' => 'تم الغاء الطلب بنجاح'], 200);
    }
}
