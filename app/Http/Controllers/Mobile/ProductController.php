<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\BuyProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     * @param string $id
     * @return JsonResponse
     */
    public function buyProduct(string $id)
    {
        $user = Auth::user();
        $service = new BuyProductService;
        $bill = $service->buy($user, $id);
        return response()->json($bill, 200);
    }
}
