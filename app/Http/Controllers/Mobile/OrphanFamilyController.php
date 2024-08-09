<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\OrphanFamily;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrphanFamilyController extends Controller
{
    /**
     * Display a listing of the Orphan Family
     * @return JsonResponse
     */
    public function index()
    {
        $families = OrphanFamily::all();
        return response()->json($families, 200);
    }

    /**
     * Display the specified Family.
     */
    public function show(string $id)
    {
        $family = OrphanFamily::with('child')->findOrFail($id);
        return response()->json($family, 200);
    }

    public function createSponsorshipCase(string $id)
    {
        $family = OrphanFamily::findOrFail($id);
        $existingCase = $family->case()->where('user_id', auth()->user()->id)
            ->where('sponsorshipable_id', $family->id)
            ->where('sponsorshipable_type', OrphanFamily::class)
            ->first();

        if ($existingCase) {
            return response()->json(['message' => 'This sponsorship case already exists.'], 409);
        }
        $case = $family->case()->create(['user_id' => auth()->user()->id]);
        $case->load('sponsorshipable');
        return response()->json($case, 201);
    }
}
