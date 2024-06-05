<?php

namespace App\Http\Controllers\Mobile;

use App\Models\User;
use App\Services\NotificationService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\MobileLoginRequest;
use App\Http\Requests\Mobile\MobileRegisterRequest;
use App\Traits\ConfirmationEmailTrait;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ConfirmationEmailTrait;

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

            /* $notificatoin = new NotificationService;
            $notificatoin->subscribeToTopic($user->deviceToken , 'mobile_user');*/
            return response()->json([
                'message' => "تم إنشاء الحساب بنجاح \nتحقق من بريدلك الإلكتروني لإستلام رمز التفعيل", 'user' => $user
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

        if ($user->email_verified_at == null)
            return response()->json(['message' => 'يرجى تفعيل حسابك قبل عملية تسجيل الدخول'], 422);

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
        $user = User::with(['wallet', 'sposership.target'])->findOrfail(Auth::user()->id);
        return response()->json(array_merge([$user, 'total donation ' => $user->TotalDonations()]), 200);
    }

    /**
     * Activate user account
     * @param string $id
     * @param Request $code
     * @return JsonResponse
     */
    protected function activateAccount($id, Request $request)
    {
        $user = User::findOrFail($id);
        if ($user->verification_code == null || $user->email_verified_at != null)
            return response()->json(['message' => 'الحساب مفعل بالفعل'], 422);
        if ($user->verification_code == $request->code) {
            $user->email_verified_at = Carbon::now();
            $user->verification_code = null;
            $user->save();
            return response()->json(['message' => 'تم تفعيل حسابك بنجاح', $user], 200);
        }
        return response()->json(['message' => 'عذراً, يرجى التأكد من الكود المرسل'], 422);
    }
}
