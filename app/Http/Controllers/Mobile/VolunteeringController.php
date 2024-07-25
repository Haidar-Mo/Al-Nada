<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\VolunteeringRequest as Vrequest;
use App\Models\User;
use App\Models\VolunteeringRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class VolunteeringController extends Controller
{
    /**
     * Display listing of user's volunteering requests
     * @return JsonResponse
     */
    public function index()
    {
        $list = Auth::user()->volunteeringRequest;
        return response()->json($list, 200);
    }
    /**
     * Store a newly created volunteering request in storage.
     * @param VolunteeringRequest $request
     * @return JsonResponse
     */
    public function store(Vrequest $request)
    {
        DB::beginTransaction();
        try {
            $user = User::findOrFail(Auth::user()->id);
            // check if he is already a volunteer
            if ($user->is_volunteer == 1)
                return response()->json(['message' => 'أنت بالفعل متطوع لدى الجمعية, شكراً لك'], 422);

            // check if he has a volunteering request on pending
            $last_volunteering = $user->volunteeringRequest->last();
            if ($last_volunteering) {
                if ($last_volunteering->status == 'انتظار')
                    return response()->json(['message' => 'عذراً, طلبك السابق قيد الانتظار'], 422);
            }

            // check Images exsistance in request
            if (!($request->hasFile('id_card_image')) || !($request->hasFile('personal_image')))
                return response()->json(['message' => 'يرجى إرفاق صورة البطاقة الشخصي و صورتك الشحصية'], 422);

            // store the request    
            $id_card_path = $request->file('id_card_image')->store('Volunteering/Id_card_image', 'public');
            $personal_image_path = $request->file('personal_image')->store('Volunteering/Personal_image', 'public');
            $volunteer = $user->volunteeringRequest()->create(array_merge($request->all(), [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'phone_number' => $user->phone_number,
                'birth_date' => $user->birth_date,
                'city_id' => 1,
                'id_card_image' => $id_card_path,
                'personal_image' => $personal_image_path,
                'Status' => 'انتظار',
            ]));
            DB::commit();
            return response()->json($volunteer, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            if (Storage::exists("public/" . $id_card_path))
                Storage::delete("public/" . $id_card_path);
            if (Storage::exists("public/" . $personal_image_path))
                Storage::delete("public/" . $personal_image_path);
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $volunteering_request = VolunteeringRequest::findOrFail($id);
        return response()->json($volunteering_request, 200);
    }

    /**
     * Update the specified resource in storage.
     * @param VolunteeringRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(Vrequest $request, string $id)
    {
        DB::beginTransaction();
        try {
            $user = User::findOrFail(Auth::user()->id);
            $volunteer = $user->volunteeringRequest()->findOrFail($id);

            if ($volunteer->status != 'انتظار')
                return response()->json(['message' => 'لا يمكن تعديل الطلب بعد الموافقة عليه أو رفضه'], 422);

            if ($request->hasFile('id_card_image')) {
                if (Storage::exists("public/" . $volunteer->id_card_image))
                    Storage::delete("public/" . $volunteer->id_card_image);

                $id_card_path = $request->file('id_card_image')->store('Volunteering/Id_card_image', 'public');
                $volunteer->id_card_image = $id_card_path;
            }

            if ($request->hasFile('personal_image')) {
                if (Storage::exists("public/" . $volunteer->personal_image))
                    Storage::delete("public/" . $volunteer->personal_image);

                $personal_image_path = $request->file('personal_image')->store('Volunteering/Personal_image', 'public');
                $volunteer->personal_image = $personal_image_path;
            }

            $volunteer->update($request->all());

            DB::commit();
            return response()->json($volunteer, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($id_card_path) && Storage::exists("public/" . $id_card_path))
                Storage::delete("public/" . $id_card_path);
            if (isset($personal_image_path) && Storage::exists("public/" . $personal_image_path))
                Storage::delete("public/" . $personal_image_path);
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
            $user = User::findOrFail(Auth::user()->id);
            $volunteer = $user->volunteeringRequest()->findOrFail($id);

            // Check if the volunteer request is not approved or rejected
            if ($volunteer->status != 'انتظار')
                return response()->json(['message' => 'لا يمكن حذف الطلب بعد الموافقة عليه أو رفضه'], 422);

            // Delete associated images
            if (Storage::exists("public/" . $volunteer->id_card_image))
                Storage::delete("public/" . $volunteer->id_card_image);

            if (Storage::exists("public/" . $volunteer->personal_image))
                Storage::delete("public/" . $volunteer->personal_image);

            // Delete the volunteering request
            $volunteer->delete();

            DB::commit();
            return response()->json(['message' => 'تم حذف طلب التطوع بنجاح'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json($e->getMessage(), 500);
        }
    }
}
