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
        $status = $request->input('status');
        $order->update(['status' => $status]);
        if ($status === 'مقبول') {
            $this->sendNotification($order->user->deviceToken, 'طلبات الندى', 'تم قبول طلبك <3');
        } elseif ($status === 'مرفوض') {
            $this->sendNotification($order->user->deviceToken, 'طلبات الندى', 'عذراً , تم رفض طلبك');
        } elseif ($status === 'جاري التوصيل') {
            $this->sendNotification($order->user->deviceToken, 'طلبات الندى', 'جاري توصيل طلبك - إستعد للاستلام :)');
        } elseif ($status === 'تم التوصيل') {
            $this->sendNotification($order->user->deviceToken, 'طلبات الندى', 'تم تأكيد الإستلام , شكراً لك');
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
