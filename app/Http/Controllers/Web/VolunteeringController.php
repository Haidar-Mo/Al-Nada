<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Volunteering;
use Illuminate\Http\Request;

class VolunteeringController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $volunteering = Volunteering::all();
        return response()->json($volunteering, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Volunteering $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Volunteering $volunteering)
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
     * Remove the specified resource from storage.
     */
    public function destroy(Volunteering $volunteering)
    {
        //
    }
}
