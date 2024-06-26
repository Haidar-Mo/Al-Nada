<?php

namespace App\Http\Controllers\Web;


use App\Http\Controllers\Controller;
use App\Http\Requests\Web\WebLoginRequest;
use App\Models\Administration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(WebLoginRequest $request)
    {
        $credentials = $request->only('user_name', 'password');

        if (!Auth::guard('web')->attempt($credentials)) {

            return response()->json(['message' => 'تحقق من الرقم أو كلمة المرور'], 401);
        }

        $user = Administration::find(Auth::guard('web')->user()->id);
        $user->tokens()->delete();
        $token = $user->createToken('access_token', ['role:web'])->plainTextToken;

        return response()->json([
            'message' => 'تم تسجيل الدخول بنجاح.',
            'access_token' => $token,
        ]);
    }


    public function logout()
    {
        $user = Administration::find(Auth::user()->id);
        $user->tokens()->delete();
        return response()->json(['message' => 'تم تسجيل الخروج بنجاح'], 200);
    }
}
