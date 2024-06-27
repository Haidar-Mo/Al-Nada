<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\VolunteerRequest;
use App\Models\Volunteer;
use Illuminate\Http\JsonResponse;

class VolunteerController extends Controller
{
    /**
     * Display a listing of the volunteers
     * @return JsonResponse
     */
    public function index()
    {
        $volunteers = Volunteer::all();
        return response()->json($volunteers);
    }

    /**
     * Display the specified volunteer 
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id)
    {
        $volunteer = Volunteer::findOrfail($id);
        return response()->json($volunteer, 200);
    }

    /**
     * Store a newly created volunteer in storage
     * @param VolunteerRequest $request
     * @return JsonResponse
     */
    public function store(VolunteerRequest $request)
    {
        $volunteer = Volunteer::create($request->all());
        return response()->json($volunteer, 201);
    }

    /**
     * Update the specified volunteer in storage
     * @param VolunteerRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(VolunteerRequest $request, string $id)
    {
        $volunteer = Volunteer::findOrFail($id);
        $volunteer->update($request->all());
        return response()->json($volunteer, 200);
    }

    /**
     * Change status to unactive
     * @param string $id
     * @return JsonResponse
     */
    public function deacticate(string $id)
    {
        $volunteer = Volunteer::findOrFail($id);
        $volunteer->status = 'غير نشط';
        $volunteer->save();
        return response()->json($volunteer, 200);
    }

    /**
     * Change status to active
     * @param string $id
     * @return JsonResponse
     */
    public function activate(string $id)
    {
        $volunteer = Volunteer::findOrFail($id);
        $volunteer->status = 'نشط';
        $volunteer->save();
        return response()->json($volunteer, 200);
    }

    /**
     * Remove the specified volunteer from storage
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id)
    {
        $volunteer = Volunteer::findOrFail($id);
        $volunteer->delete();
        return response()->json(null, 204);
    }
}
