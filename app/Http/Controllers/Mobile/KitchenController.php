<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\OrderRequest;
use App\Http\Requests\Web\KitchenRequest;
use App\Models\Administration;
use App\Models\Kitchen;
use App\Notifications\OrderDishNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class KitchenController extends Controller
{
    /**
     * Display a listing of the Dishs
     * @return JsonResponse
     */
    public function index()
    {
        $dishes = Kitchen::all();
        return response()->json($dishes);
    }

    /**
     * Display the specified Dish
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id)
    {
        $dishe = Kitchen::findOrfail($id);
        return response()->json($dishe, 200);
    }

    /**
     * Buy the specific Dish
     * @param OrderRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function orderProduct(OrderRequest $request, string $id)
    {
        $user = Auth::user();
        $dishe = Kitchen::findOrFail($id);
        if (!$dishe->is_available)
            return response()->json(['message' => 'المنتج غير متاح حالياً'], 422);
        $order = $dishe->order()->create(array_merge($request->all(), ['user_id' => $user->id]));

        // Send Notification :
        $target  = Administration::all();
        Notification::send($target, new OrderDishNotification($order));

        return response()->json($order, 201);
    }
}
