<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the City.
     * @return JsonResponse
     */
    public function index()
    {
        $cities = City::all();
        return response()->json($cities);
    }

    /**
     * Display the specified City.
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id)
    {
        $city = City::findOrfail($id);
        return response()->json($city, 200);
    }

    /**
     * Store a newly created City in storage.
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $data =  $request->validate([
            'name' => 'required|unique:cities,name'
        ]);
        $city = City::create($data);
        return response()->json($city, 201);
    }

    /**
     * Update the specified City in storage.
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(Request $request, string $id)
    {
        $city = City::findOrfail($id);
        $data = $request->validate(['name' => ['required', 'unique:cities,name,' . $id . ',id']]);
        $city->update($data);
        return response()->json($city, 200);
    }

    /**
     * Remove the specified resource from storage.
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id)
    {
        $city = City::findOrFail($id);
        $city->delete();
        return response()->json(null, 204);
    }
}
