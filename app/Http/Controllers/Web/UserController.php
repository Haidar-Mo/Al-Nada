<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the Mobile Users
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 20);
        $orderBy = $request->input('order_by', 'id');
        $order = $request->input('order', 'asc');
        $users = User::orderBy($orderBy, $order)->paginate($perPage)->through(function ($user) {
            return $user->makeVisible(['is_active', 'email_verified_at']);
        });
        return response()->json($users, 200);
    }

    /**
     * Display the specified User
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id)
    {
        $user = User::findOrfail($id)->makeVisible(['is_active', 'email_verified_at']);
        return response()->json($user, 200);
    }


    /**
     * Ban the specified User
     * @param string $id
     * @return JsonResponse
     */
    public function ban(string $id)
    {
        $user = User::findOrfail($id);
        if (!$user->isActive())
            return response()->json(['message' => 'user is already banned'], 422);
        $user->update([
            'is_active' => 0
        ]);
        return response()->json(['message' => 'user has been banned successfully'], 200);
    }

    /**
     * Activate the specified User
     * @param string $id
     * @return JsonResponse
     */
    public function Activate(string $id)
    {
        $user = User::findOrfail($id);
        if ($user->isActive())
            return response()->json(['message' => 'user is already active'], 422);
        $user->update([
            'is_active' => 1
        ]);
        return response()->json(['messge' => 'user has been activated successfully'], 200);
    }

    /**
     * Remove the specified User from storage
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id)
    {
        //
    }
}
