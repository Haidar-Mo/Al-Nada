<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\OrphanFamily;
use App\Models\OrphanFamilyChild;
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

    public function childIndex()
    {
        $children = OrphanFamilyChild::where('is_supported', 1)
            ->where('visible', 1)
            ->with('family')
            ->latest()
            ->get()
            ->makeHidden(['is_supported', 'visible', 'birth_date']);
        return response()->json($children, 200);
    }
    /**
     * Display the specified Family
     */
    public function show(string $id)
    {
        $family = OrphanFamily::with('child')->findOrFail($id);
        return response()->json($family, 200);
    }

    public function childShow(string $id)
    {
        $child = OrphanFamilyChild::with('family')
            ->findOrFail($id)
            ->makeHidden(['is_supported', 'visible', 'birth_date']);
        return response()->json($child, 200);
    }

    public function createSponsorshipCase(string $id)
    {
        $child = OrphanFamilyChild::findOrFail($id);
        $existingCase = $child->case()->where('user_id', auth()->user()->id)
            ->where('sponsorshipable_id', $child->id)
            ->where('sponsorshipable_type', OrphanFamilyChild::class)
            ->first();

        if ($existingCase) {
            return response()->json(['message' => 'This sponsorship case already exists.'], 409);
        }
        $case = $child->case()->create(['user_id' => auth()->user()->id]);
        $case->load('sponsorshipable');
        return response()->json($case, 201);
    }
}
