<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
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
        $query = Order::with('orderable', 'user');
        $orders = $this->applyFilters($request, $query);
        return response()->json($orders);
    }

    public function index2()
    {

        $newOrders = Order::with('user', 'orderable')
            ->where('status', 'جديد')
            ->get();

        $uniqueUsers = $newOrders->pluck('user')->unique('id');

        $usersWithOrders = $uniqueUsers->map(function ($user) use ($newOrders) {

            $userOrders = $newOrders->where('user_id', $user->id)->values();

            $productCount = $userOrders->where('orderable_type', 'App\Models\Product')->count();
            $productPrice = $userOrders->where('orderable_type', 'App\Models\Product')->map(function ($productPrice) {
                return $productPrice->orderable->price;
            })->sum();

            $kitchenCount = $userOrders->where('orderable_type', 'App\Models\Kitchen')->count();
            $kitchenPrice = $userOrders->where('orderable_type', 'App\Models\Kitchen')->map(function ($kitchenPrice) {
                return $kitchenPrice->orderable->price;
            })->sum();

            return [
                'user' => $user,
                'product_count' => $productCount,
                'Total_product_price' => $productPrice,
                'kitchen_count' => $kitchenCount,
                'Total_kitchen_price' => $kitchenPrice,
            ];
        })->values();
        return response()->json(['user with orders'=>$usersWithOrders],200);
    }

    public function showUserCart(string $id)
    {
        $user = User::findOrFail($id);

        $orders = $user->order()
            ->with('orderable')
            ->where('status', 'جديد')
            ->orWhere('status', 'قيد المعالجة')
            ->get();
        return response()->json(['user' => $user, 'orders' => $orders], 200);
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
