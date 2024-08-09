<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Traits\NotificationTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use NotificationTrait;

    /**
     * Display a listing of the Orders
     * @param Request $request => User input for filtering
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 20);
        $orderBy = $request->input('order_by', 'id');
        $order = $request->input('order', 'asc');
        $filter = $request->input('filter', 'id');
        $search  = $request->input('search');

        $orders = Order::with('orderable', 'user')->where($filter, 'LIKE', '%' . $search . '%')->orderBy($orderBy, $order)->paginate($perPage);
        return response()->json($orders);
    }

    /**
     * Display the specified Order
     * @param string $id => The ID of the order
     * @return JsonResponse
     */
    public function show(string $id)
    {
        $order = Order::with('orderable', 'user')->findOrFail($id);
        return response()->json($order, 200);
    }

    /**
     * To change the status of the order
     * @param Request $request => The user status input
     * @param string $id =>  The ID of the order
     * @return JsonResponse
     */
    public function statusChange(Request $request, string $id)
    {
        $order = Order::findOrfail($id);
        $status = $request->status;
        $order->update(['status' => $status]);
        if ($status === 'قيد المعالجة') {
            $this->sendNotification($order->user->deviceToken, 'طلبات الندى', 'جاري معالجة - إستعد للاستلام :)');
        } elseif ($status === 'تم الاستلام') {
            $this->sendNotification($order->user->deviceToken, 'طلبات الندى', 'تم التحقق من تسليم الطلب <3');
        } elseif ($status === 'ملغي') {
            $this->sendNotification($order->user->deviceToken, 'طلبات الندى', 'عذراً, تم إلغاء الطلب');
        }
        return response()->json($order, 200);
    }
    /**
     * Remove the specified Order from storage
     * @param string $id => The ID of the Order
     * @return JsonResponse
     */
    public function destroy(string $id)
    {
        $order = Order::find($id);
        $order->delete();
        return response()->json(null, 204);
    }
}
