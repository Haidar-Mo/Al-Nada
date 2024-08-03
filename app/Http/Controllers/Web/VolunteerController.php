<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\VolunteerRequest;
use App\Models\Volunteer;
use App\Models\VolunteerWorkPeriod;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VolunteerController extends Controller
{
    /**
     * Display a listing of the volunteers
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 20);
        $orderBy = $request->input('order_by', 'id');
        $order = $request->input('order', 'asc');
        $filter = $request->input('filter', 'id');
        $search  = $request->input('search');

        $volunteers = Volunteer::with('request', 'city')
            ->where($filter, 'LIKE', "%{$search}%")
            ->orderBy($orderBy, $order)
            ->paginate($perPage);
        return response()->json($volunteers);
    }

    /**
     * Display the specified volunteer 
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id)
    {
        $volunteer = Volunteer::with('request', 'workPeriod', 'city')->findOrfail($id);
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
        $volunteer->workPeriod()->create(['start_date' => Carbon::now()]);
        $volunteer->load('city');
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
        $volunteer = Volunteer::with(['request', 'city'])->findOrFail($id);
        $volunteer->update($request->all());
        return response()->json($volunteer, 200);
    }

    /**
     * Change status to unactive
     * @param string $id
     * @return JsonResponse
     */
    public function deactivate(string $id)
    {
        $volunteer = Volunteer::findOrFail($id);
        $volunteer->active = 0;
        $volunteer->save();
        $period = $volunteer->workPeriod()->latest()->first();
        $period->update(['end_date' => now()]);
        $volunteer->load('request', 'city');
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
        $volunteer->active = 1;
        $volunteer->save();
        $volunteer->workPeriod()->create(['start_date' => now()]);
        $volunteer->load('request', 'city');
        return response()->json($volunteer, 200);
    }

    public function rate(Request $request, string $id)
    {
        $request->validate(['rate' => 'required|between:0,5']);
        $period = VolunteerWorkPeriod::findOrFail($id);
        $volunteer = $period->volunteer;
        $period->rate = $request->input('rate');
        $period->save();
        $volunteer->rate = $volunteer->workPeriod()->sum('rate') / $volunteer->workPeriod()->count();
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
