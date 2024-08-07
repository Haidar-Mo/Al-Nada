<?php

namespace App\Http\Controllers\Mobile;

use App\Models\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\MobileLoginRequest;
use App\Http\Requests\Mobile\MobileRegisterRequest;

use App\Traits\ConfirmationEmailTrait;
use App\Traits\NotificationTrait;
use App\Traits\ResetPasswordEmailingTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ConfirmationEmailTrait;
    use ResetPasswordEmailingTrait;
    use NotificationTrait;

    /**
     * Create new Account 
     * @param MobileRegisterRequest $request
     * @return JsonResponse
     */
    public function register(MobileRegisterRequest $request)
    {

        DB::beginTransaction();
        try {
            $code = $this->generateVerificationCode();
            $user = User::create(array_merge($request->all(), ['verification_code' => $code]));
            $wallet = $user->wallet()->create();
            $this->sendVerificationEmail($user);
            DB::commit();

            //$this->subscribeToTopic($user->deviceToken, 'mobile_user');
            return response()->json([
                'message' => "تم إنشاء الحساب بنجاح, تحقق من بريدلك الإلكتروني لإستلام رمز التفعيل", 'user' => $user
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function login(MobileLoginRequest $request)
    {
        //$credentials = $request->only('phone_number', 'password');
        $credentials = $request->only('email', 'password');

        if (!Auth::guard('mobile')->attempt($credentials)) {

            return response()->json(['message' => 'تحقق من البريد الألكتروني أو كلمة المرور'], 401);
        }
        $user = User::find(Auth::guard('mobile')->user()->id);
        $user->tokens()->delete();
        $token = $user->createToken('access_token', ['role:mobile'])->plainTextToken;

        return response()->json([
            'message' => 'User logged in successfully.',
            'access_token' => $token,
            'user' => $user,
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
        $user = User::with(['wallet', 'sposership.target'])->findOrfail(Auth::user()->id);
        $total_private_donation = strval($user->donation()->where('type', 'مالي')->where('status', '!=', 'جديد')->sum('amount'));
        $total_campaign_donation = strval($user->wallet->donationCampaign()->where('type', 'مالي')->sum('amount'));
        return response()->json(array_merge([
            'user' => $user,
            'total donation ' => $total_private_donation,
            'total campaign donation ' => $total_campaign_donation
        ]), 200);
    }

    /**
     * Activate user account
     * @param string $id
     * @param Request $code
     * @return JsonResponse
     */
    protected function activateAccount($id, Request $code)
    {
        $user = User::findOrFail($id);
        if ($user->verification_code == null || $user->email_verified_at != null)
            return response()->json(['message' => 'الحساب مفعل بالفعل'], 422);
        if ($user->verification_code == $code->code) {
            $user->email_verified_at = Carbon::now();
            $user->verification_code = null;
            $user->save();
            return response()->json(['message' => 'تم تفعيل حسابك بنجاح', $user], 200);
        }
        return response()->json(['message' => 'عذراً, يرجى التأكد من الكود المرسل'], 422);
    }

    /**
     * Reset Password
     * @param Request $request
     * @return JsonResponse
     */
    public function autoResetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'phone_number' => 'required|exists:users,phone_number'
        ]);
        $user = User::where('phone_number', $request->phone_number)->where('email', $request->email)->first();
        if (!$user)
            return response()->json(['message' => 'الرقم و البريد غير متطابقين'], 422);
        $password = $this->resetPassword($user);
        $this->sendResetPasswordEmail($user, $password);
        return response()->json(['message' => 'تم تغيير كلمة المرور, راجع بريدك الإلكتروني'], 200);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6',
        ]);
        $user = User::find(Auth::user()->id);
        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json(['message' => 'كلمة مرور الحالية غير صحيحة'], 422);
        }
        $user->password =  Hash::make($request->new_password);
        $user->save();
        return response()->json(['message' => 'تم تغيير كلمة مرور حسابك'], 200);
    }
}
