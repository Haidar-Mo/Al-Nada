<?php

namespace App\Http\Controllers\mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\SponsershipDocumentRequest;
use App\Models\SponsershipDocument;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SponsershipDocumentController extends Controller
{
    /**
     * Store a newly created Document in storage.
     */
    public function store(SponsershipDocumentRequest $request)
    {
        $user = User::find(Auth::id());
        if ($user->sponsershipDocument) {
            return response()->json(['message' => 'you cant create more than one document'], 422);
        }
        $document = $user->sponsershipDocument()->create($request->all());
        return response()->json($document, 201);
    }

    /**
     * Display my Sponsership Document.
     */
    public function show()
    {
        $user = Auth::user();
        $document = $user->sponsershipDocument;
        return response()->json($document, 200);
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SponsershipDocument $sponsershipDocument)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SponsershipDocument $sponsershipDocument)
    {
        //
    }
}
