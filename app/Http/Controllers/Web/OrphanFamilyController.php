<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\OrphanFamilyRequest;
use App\Models\OrphanFamily;
use Illuminate\Http\Request;

class OrphanFamilyController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 20);
        $orderBy = $request->input('order_by', 'id');
        $order = $request->input('order', 'asc');
        $filter = $request->input('filter', 'id');
        $search  = $request->input('search');

        $families = OrphanFamily::where($filter, 'LIKE', $search)
            ->orderBy($orderBy, $order)
            ->paginate($perPage);

        return response()->json($families, 200);
    }

    public function show(string $id)
    {
        $family = OrphanFamily::findOrFail($id);
        return response()->json($family, 200);
    }
    public function getFamilyChildren(Request $request, string $id)
    {
        $family = OrphanFamily::with('orphans')->findOrFail($id);
        return response()->json($family->orphans, 200);
    }

    public function getFamilyStatement(Request $request, string $id)
    {
        $family = OrphanFamily::with('statement')->findOrFail($id);
        return response()->json($family->statement, 200);
    }

    public function store(OrphanFamilyRequest $request)
    {
        $family = OrphanFamily::create($request->all());
        return response()->json($family, 201);
    }

    public function addChild(Request $request, string $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'academic_level' => 'required|in:غير محدد,ابتدائي ,اعدادي,ثانوي,جامعي',
            'is_supported' => 'boolean'
        ]);
        $family = OrphanFamily::findOrFail($id);
        $child = $family->orphans()->create($data);
        return response()->json($child, 201);
    }

    public function addStatement(Request $request, string $id)
    {
        $data = $request->validate([
            'statement_first_date' => 'required|date',
            'income_source' => 'required|string',
            'mony_saving' => 'required|decimal:0,9999999',
            'poor_level' => 'required|string',
            'other_association' => 'nullable|string',
            'supply' => 'nullable|string',
            'note' => 'nullable|string',
            'committee' => 'required|string',
            'committee_report' => 'required|string',
            'remove_statement_number' => 'nullable',
            'remove_date' => 'nullable|date',
            'remove_reson' => 'nullable|string',
        ]);
        $family = OrphanFamily::findOrFail($id);
        $statement =  $family->statement()->create($data);
        return response()->json($statement, 201);
    }
}
