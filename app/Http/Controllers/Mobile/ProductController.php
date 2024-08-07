<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\OrderRequest;
use App\Models\Administration;
use App\Models\Product;
use App\Notifications\OrderProductNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class ProductController extends Controller
{
    /**
     * Display a listing of the Product
     * @return JsonResponse
     */
    public function index()
    {
        $products = Product::all();
        return response()->json($products);
    }

    /**
     * Display the specified Product
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id)
    {
        $product = Product::findOrfail($id);
        return response()->json($product, 200);
    }

    /**
     * Buy the specific Product
     * @param OrderRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function orderProduct(OrderRequest $request, string $id)
    {
        $user = Auth::user();
        $product = Product::findOrFail($id);
        if (!$product->is_available)
            return response()->json(['message' => 'المنتج غير متاح حالياً'], 422);
        $order = $product->order()->create(array_merge($request->all(), ['user_id' => $user->id]));

        // Send Notification :
        $target  = Administration::all();
        Notification::send($target, new OrderProductNotification($order));
        
        return response()->json($order, 201);
    }
}
