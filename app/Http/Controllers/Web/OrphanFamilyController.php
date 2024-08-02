<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\OrphanFamilyChildRequest;
use App\Http\Requests\Web\OrphanFamilyRequest;
use App\Http\Requests\Web\OrphanFamilyStatementRequest;
use App\Models\OrphanFamily;
use App\Models\OrphanFamilyChild;
use App\Models\OrphanFamilyStatement;
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
    public function getFamilyChildren(string $id)
    {
        $family = OrphanFamily::with('orphan')->findOrFail($id);
        return response()->json($family->orphans, 200);
    }

    public function getFamilyStatement(string $id)
    {
        $family = OrphanFamily::with('statement')->findOrFail($id);
        return response()->json($family->statement, 200);
    }

    public function store(OrphanFamilyRequest $request)
    {
        $family = OrphanFamily::create($request->all());
        return response()->json($family, 201);
    }

    public function addChild(OrphanFamilyChildRequest $request, string $id)
    {
        $family = OrphanFamily::findOrFail($id);
        $child = $family->orphan()->create($request->all());
        return response()->json($child, 201);
    }

    public function addStatement(OrphanFamilyStatementRequest $request, string $id)
    {
        $family = OrphanFamily::findOrFail($id);
        $statement =  $family->statement()->create($request->all());
        return response()->json($statement, 201);
    }

    public function update(OrphanFamilyRequest $request, string $id)
    {
        $family = OrphanFamily::findOrFail($id);
        $family->update($request->all());

        return response()->json($family, 200);
    }
    public function updateChild(OrphanFamilyChildRequest $request, string $id)
    {
        $child = OrphanFamilyChild::findOrFail($id);
        $child->update($request->all());
        return response()->json($child, 200);
    }

    public function updateStatement(OrphanFamilyStatementRequest $request, string $id)
    {
        $statement = OrphanFamilyStatement::findOrFail($id);
        $statement->update($request->all());
        return response()->json($statement, 200);
    }

    public function destroy(string $id)
    {
        $family = OrphanFamily::findOrFail($id);
        $family->delete();
        return response()->json(null, 204);
    }

    public function destroyChild(string $id)
    {
        $child = OrphanFamilyChild::findOrFail($id);
        $child->delete();
        return response()->json(null, 204);
    }

    public function destroyStatement(string $id)
    {
        $statement = OrphanFamilyStatement::findOrFail($id);
        $statement->delete();
        return response()->json(null, 204);
    }
}
