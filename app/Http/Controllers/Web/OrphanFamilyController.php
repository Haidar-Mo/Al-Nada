<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\OrphanFamilyChildRequest;
use App\Http\Requests\Web\OrphanFamilyRequest;
use App\Http\Requests\Web\OrphanFamilyStatementRequest;
use App\Models\OrphanFamily;
use App\Models\OrphanFamilyChild;
use App\Models\OrphanFamilyStatement;
use App\Models\StatusUpdate;
use Illuminate\Http\Request;

class OrphanFamilyController extends Controller
{

    /** SHOW SECTION  **/


    public function index(Request $request)
    {
        $query = OrphanFamily::query();

        $families = $this->applyFilters($request, $query)
            ->through(function ($family) {
                $family->makeVisible('visible');
                return $family;
            });;
        return response()->json($families, 200);
    }

    public function show(string $id)
    {
        $family = OrphanFamily::findOrFail($id)->makeVisible('visible');
        return response()->json($family, 200);
    }
    public function getFamilyChildren(string $id)
    {
        $family = OrphanFamily::with('child')->findOrFail($id)->makeVisible('visible');
        return response()->json($family->child, 200);
    }

    public function getFamilyStatement(string $id)
    {
        $family = OrphanFamily::with('statement')->findOrFail($id)->makeVisible('visible');
        return response()->json($family->statement, 200);
    }


    /** STORE SECTION **/

    public function store(OrphanFamilyRequest $request)
    {
        $family = OrphanFamily::create($request->all());
        $family->makeVisible('visible');
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

    /** UPDATE SECTION  **/

    public function update(OrphanFamilyRequest $request, string $id)
    {
        $family = OrphanFamily::findOrFail($id);
        $family->update($request->all());

        return response()->json($family, 200);
    }

    public function makeFamilyVisible(string $id)
    {
        $family = OrphanFamily::findOrFail($id);
        $family->visible = true;
        $family->save();
        return response()->json($family, 200);
    }

    public function makeFamilyInvisible(string $id)
    {
        $family = OrphanFamily::findOrFail($id);
        $family->visible = false;
        $family->save();
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

    /** DESTROY SECTION **/

    public function destroy(string $id)
    {
        $family = OrphanFamily::findOrFail($id);
        $family->delete();
        return response()->json(null, 204);
    }

    public function deleteChild(string $id)
    {
        $child = OrphanFamilyChild::findOrFail($id);
        $child->delete();
        return response()->json(null, 204);
    }

    public function deleteStatement(string $id)
    {
        $statement = OrphanFamilyStatement::findOrFail($id);
        $statement->delete();
        return response()->json(null, 204);
    }

    public function deleteStatusUpdate(string $id)
    {
        $update = StatusUpdate::findOrFail($id);
        $update->delete();
        return response()->json(null, 204);
    }
}
