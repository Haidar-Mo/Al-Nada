<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\VolunteeringRequest;
use App\Models\User;
use App\Models\Volunteering;
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
        $list = Auth::user()->volunteering;
        return response()->json($list, 200);
    }
    /**
     * Store a newly created volunteering request in storage.
     * @param VolunteeringRequest $request
     * @return JsonResponse
     */
    public function store(VolunteeringRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = User::findOrFail(Auth::user()->id);

            if ($user->is_volunteer == 1)
                return response()->json(['message' => 'أنت بالفعل متطوع لدى الجمعية, شكراً لك'], 422);
            if ($user->volunteering->last()) {
                if ($user->volunteering->last()->status == 'انتظار')
                    return response()->json(['message' => 'عذراً, طلبك السابق قيد الانتظار'], 422);
            }
            if (!($request->hasFile('id_card_image')) || !($request->hasFile('personal_image')))
                return response()->json(['message' => 'يرجى إرفاق صورة البطاقة الشخصي و صورتك الشحصية'], 422);
            $id_card_path = $request->file('id_card_image')->store('Volunteering', 'public');
            $personal_image_path = $request->file('personal_image')->store('Volunteering', 'public');
            $volunteer = $user->volunteering()->create(array_merge($request->all(), [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'phone_number' => $user->phone_number,
                'birth_date' => $user->birth_date,
                'city_id' => $user->city_id,
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
        $volunteering_request = Volunteering::findOrFail($id);
        return response()->json($volunteering_request, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VolunteeringRequest $request, string $id)
    {
        $volunteering_request = Volunteering::findOrFail($id);
        if ($volunteering_request->user_id != Auth::user()->id)
            return response()->json(['message' => 'Unauthorized'], 401);
        if ($volunteering_request->status != 'انتظار')
            return response()->json(['message' => 'لا يمكن تعديل طلبك بعد أن تم قبوله أو رفضه'], 422);
        $volunteering_request->update($request->all());
        return response()->json($volunteering_request, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $volunteering_request = Volunteering::findOrFail($id);
        if ($volunteering_request->status != 'انتظار')
            return response()->json(['message' => 'عذراً, لايمكنك الغاء طلبك'], 422);
        $volunteering_request->delete();
        return response()->json(['message' => 'تم إلغاء طلبك بنجاح'], 200);
    }
}
