<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\MobileLoginRequest;
use App\Http\Requests\Mobile\MobileRegisterRequest;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{

    public function register(MobileRegisterRequest $request)
    {
        DB::beginTransaction();
        try {

            $user = User::create($request->all());
            $wallet = $user->wallet()->create();
            DB::commit();

            /* $notificatoin = new NotificationService;
            $notificatoin->subscribeToTopic($user->deviceToken , 'mobile_user');*/
            return response()->json(['user' => $user, 'wallet' => $wallet], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], $e->getCode() ?: 500);
        }
    }

    public function login(MobileLoginRequest $request)
    {
        //$credentials = $request->only('phone_number', 'password');
        $credentials = $request->only('email', 'password');

        if (!Auth::guard('mobile')->attempt($credentials)) {

            return response()->json(['message' => 'تحقق من الرقم أو كلمة المرور'], 401);
        }
        $user = User::find(Auth::guard('mobile')->user()->id);

        /* add ['role:user'] as second param */
        $token = $user->createToken('access_token')->plainTextToken;

        return response()->json([
            'message' => 'User logged in successfully.',
            'access_token' => $token,
        ]);
    }


    public function logout()
    {
        $user = User::find(Auth::user()->id);
        $user->tokens()->delete();
        return response()->json(['message' => 'تم تسجيل الخروج بنجاح'], 200);
    }

    public function profile()
    {

        $user = User::with('wallet')->findOrfail(Auth::user()->id);
        return response()->json($user, 200);
    }
}
