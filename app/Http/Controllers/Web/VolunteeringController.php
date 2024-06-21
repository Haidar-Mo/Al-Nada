<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Volunteering;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VolunteeringController extends Controller
{
    /**
     * Display a listing of the Volunteer Requests.
     * @return JsonResponse
     */
    public function index()
    {
        $volunteer_request = Volunteering::with('city')->all();
        return response()->json($volunteer_request, 200);
    }

    /**
     * Display the specified Voulnteer request
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id)
    {
        $volunteer_request = Volunteering::with('city')->findOrFail($id);
        return response()->json($volunteer_request, 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Volunteering $request)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Volunteering $volunteering)
    {
        //
    }

    /**
     * Remove the specified voulnteer request from storage
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id)
    {
        $volunteer_request = Volunteering::findOrFail($id);
        $volunteer_request->delete();
        return response()->json(null, 204);
    }
}
