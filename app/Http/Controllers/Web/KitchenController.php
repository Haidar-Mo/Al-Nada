<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\KitchenRequest;
use App\Models\kitchen;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class KitchenController extends Controller
{
    /**
     * Display a listing of the Kitchen dishes
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 20);
        $orderBy = $request->input('order_by', 'id');
        $order = $request->input('order', 'asc');
        $filter = $request->input('filter', 'id');
        $search  = $request->input('search');

        $dishes = kitchen::where($filter, 'LIKE', '%' . $search . '%')->orderBy($orderBy, $order)->paginate($perPage);
        return response()->json($dishes, 200);
    }

    /**
     * Display the specified Kitchen dish
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id)
    {
        $dish = kitchen::findOrFail($id);
        return response()->json($dish, 200);
    }


    /**
     * Store a newly created Dish in storage
     * @param KitchenRequest $request
     * @return JsonResponse
     */
    public function store(KitchenRequest $request)
    {
        DB::beginTransaction();
        try {
            $path = '';
            if ($request->file('image'))
                $path = $request->file('image')->store('Kitchen', 'public');
            $dish = Kitchen::create([
                'name' => $request->name,
                'maker_name' => $request->maker_name,
                'description' => $request->description,
                'price' => $request->price,
                'is_available' => $request->is_available,
                'image' => $path,
            ]);
            DB::commit();
            return response()->json($dish, 200);
        } catch (\Exception $e) {
            if (Storage::exists("public/" . $path))
                Storage::delete("public/" . $path);
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Make the specific Dish available
     * @param string $id
     * @return JsonResponse
     */
    public function makeAvailable(string $id)
    {
        DB::beginTransaction();
        try {
            $dish = kitchen::findOrFail($id);
            $dish->update([
                'is_available' => true,
            ]);
            DB::commit();
            return response()->json($dish, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json($e->getMessage(), 500);
        }
    }
    /**
     * Make the specific Dish Not available
     * @param string $id
     * @return JsonResponse
     */
    public function makeNotAvailable(string $id)
    {
        DB::beginTransaction();
        try {
            $dish = Kitchen::findOrFail($id);
            $dish->update([
                'is_available' => false,
            ]);
            DB::commit();
            return response()->json($dish, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Update the specified resource in storage
     * @param KitchenRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(KitchenRequest $request, string $id)
    {
        DB::beginTransaction();
        try {
            $dish = Kitchen::findOrFail($id);
            if ($request->file('image')) {
                if ($dish->image) {
                    if (Storage::exists("public/" . $dish->image))
                        Storage::delete("public/" . $dish->image);
                }
                $path = $request->file('image')->store('Kitchen', 'public');
                $dish->update([
                    'name' => $request->name,
                    'maker_name' => $request->maker_name,
                    'description' => $request->description,
                    'price' => $request->price,
                    'image' => $path,
                ]);
            } else {
                $dish->update([
                    'name' => $request->name,
                    'maker_name' => $request->maker_name,
                    'description' => $request->description,
                    'price' => $request->price,
                ]);
            }
            DB::commit();
            return response()->json($dish, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $dish = Kitchen::findOrFail($id);
            if ($dish->image) {
                if (Storage::exists("public/" . $dish->image))
                    Storage::delete("public/" . $dish->image);
            }
            $dish->delete();
            DB::commit();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json($e->getMessage(), 500);
        }
    }
}
