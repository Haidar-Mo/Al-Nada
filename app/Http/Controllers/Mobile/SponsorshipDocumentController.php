<?php

namespace App\Http\Controllers\mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\SponsorshipDocumentRequest;
use App\Models\SponsershipDocument;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SponsorshipDocumentController extends Controller
{
    /**
     * Store a newly created Document in storage
     * @param SponsorshipDocumentRequest $request All needed data in the document 
     * @return JsonResponse
     */
    public function store(SponsorshipDocumentRequest $request)
    {
        $user = auth()->user();
        if ($user->sponsorshipDocument) {
            return response()->json(['message' => 'you cant create more than one document'], 422);
        }
        $document = $user->sponsorshipDocument()->create($request->all());
        return response()->json($document, 201);
    }

    /**
     * Display my Sponsership Document
     * @return JsonResponse
     */
    public function show()
    {
        $user = Auth::user();
        $document = $user->sponsorshipDocument;
        return response()->json($document, 200);
    }

    /**
     * Update the specified Document in storage
     * @param SponsorshipDocumentRequest $request All needed data in the document 
     * @param string $id The ID of the document
     * @return JsonResponse
     */
    public function update(SponsorshipDocumentRequest $request, string $id)
    {
        $user = auth()->user();
        if ($user->sponsorshipDocument)
            $user->sponsorshipDocument->update($request->all());
        return response()->json($user->sponsorshipDocument, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        //
    }
}
