<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Volunteer;
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
        $volunteer_request = Volunteering::with('city')->get();
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
     * Accept volunteering request
     * @param string $id
     * @return JsonResponse
     */
    public function accept(string $id)
    {
        $volunteer_request = Volunteering::find($id);
        if ($volunteer_request->status != 'انتظار')
            return response()->json(['message' => 'الطلب معالج بالفعل'], 422);
        $volunteer_request->update([
            'rejecting_reason' => null,
            'status' => 'مقبول'
        ]);
        $volunteer = Volunteer::create([
            'first_name' => $volunteer_request->first_name,
            'last_name' => $volunteer_request->last_name,
            'phone_number' => $volunteer_request->phone_number,
            'birth_date' => $volunteer_request->birth_date,
            'academic_level' => $volunteer_request->academic_level,
            'status' => 'نشط'
        ]);
        return response()->json($volunteer, 200);
    }

    /**
     * Reject volunteering request
     * @param string $id
     * @return JsonResponse
     */
    public function reject(Request $request, string $id)
    {
        $request->validate(['rejecting_reason' => ['required', 'string']]);
        $volunteer_request = Volunteering::find($id);
        if ($volunteer_request->status != 'انتظار')
            return response()->json(['message' => 'الطلب معالج بالفعل'], 422);
        $volunteer_request->update([
            'rejecting_reason' => $request->rejecting_reason,
            'status' => 'مرفوض'
        ]);
        return response()->json($volunteer_request, 200);
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
