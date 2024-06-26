<?php

namespace App\Http\Controllers\Web;


use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\ProductRequest;
use App\Models\SellingHistory;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the Product.
     * @return JsonResponse
     */
    public function index()
    {
        $products = Product::all();
        return response()->json($products);
    }

    /**
     * Display the specified Product.
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id)
    {
        $product = Product::findOrfail($id);
        return response()->json($product, 200);
    }


    /**
     * Store a newly created Product in storage.
     * @param ProductRequest $request
     * @return JsonResponse
     */
    public function store(ProductRequest $request)
    {
        DB::beginTransaction();
        try {
            $path = '';
            if ($request->file('image'))
                $path = $request->file('image')->store('Product', 'public');
            $product = Product::create([
                'name' => $request->name,
                'maker_name' => $request->maker_name,
                'description' => $request->description,
                'price' => $request->price,
                'is_available' => $request->is_available,
                'image' => $path,
            ]);
            DB::commit();
            return response()->json($product, 200);
        } catch (\Exception $e) {
            if (Storage::exists("public/" . $path))
                Storage::delete("public/" . $path);
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    /**
     * Make the specific Product available
     * @param string $id
     * @return JsonResponse
     */
    public function makeAvailable(string $id)
    {
        DB::beginTransaction();
        try {
            $product = Product::findOrFail($id);
            $product->update([
                'is_available' => true,
            ]);
            DB::commit();
            return response()->json($product, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json($e->getMessage(), 500);
        }
    }
    /**
     * Make the specific Product Not available
     * @param string $id
     * @return JsonResponse
     */
    public function makeNotAvailable(string $id)
    {
        DB::beginTransaction();
        try {
            $product = Product::findOrFail($id);
            $product->update([
                'is_available' => false,
            ]);
            DB::commit();
            return response()->json($product, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json($e->getMessage(), 500);
        }
    }
    /**
     * Update the specified Product in storage.
     * @param  ProductRequest $request
     * @param stirng $id
     * @return JsonResponse
     */
    public function update(ProductRequest $request, string $id)
    {
        DB::beginTransaction();
        try {
            $product = Product::findOrFail($id);
            if ($request->file('image')) {
                if ($product->image) {
                    if (Storage::exists("public/" . $product->image))
                        Storage::delete("public/" . $product->image);
                }
                $path = $request->file('image')->store('products');
                $product->update([
                    'name' => $request->name,
                    'maker_name' => $request->maker_name,
                    'description' => $request->description,
                    'price' => $request->price,
                    'image' => $path,
                ]);
            } else {
                $product->update([
                    'name' => $request->name,
                    'maker_name' => $request->maker_name,
                    'description' => $request->description,
                    'price' => $request->price,
                ]);
            }
            DB::commit();
            return response()->json($product, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified Product from storage.
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $product = Product::findOrFail($id);
            if ($product->image)
                if (Storage::exists("public/" . $product->image))
                    Storage::delete("public/" . $product->image);
            $product->delete();
            DB::commit();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json($e->getMessage(), 500);
        }
    }

}
