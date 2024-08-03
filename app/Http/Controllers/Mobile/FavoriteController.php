<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Favorite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isEmpty;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $favorites = Auth::user()->favorite;
        return response()->json($favorites, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(string $id)
    {
        $user = User::find(Auth::id());
        $campaign = Campaign::findOrFail($id);
        $favorite = $user->favorite()->where('campaign_id', $id)->first();
        if ($favorite)
            return response()->json(['message' => 'الحملة مضافة للمفضلة مسبقاً'], 409);
        $favorite = $user->favorite()->create(['campaign_id' => $campaign->id]);
        return response()->json($favorite, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $favorite = Favorite::with(['campaign'])->findOrfail($id);
        return response()->json($favorite, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $favorite = Favorite::findOrFail($id);
        $favorite->delete();
        return response()->json(null, 204);
    }
}
