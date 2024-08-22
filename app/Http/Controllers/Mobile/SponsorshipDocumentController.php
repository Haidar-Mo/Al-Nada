<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\SponsorshipDocumentRequest;
use App\Models\SponsorshipDocumentUpdate;
use Illuminate\Http\JsonResponse;
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
    public function update(SponsorshipDocumentRequest $request)
    {
        $user = auth()->user();
        if (!$user->sponsorshipDocument()->exists())
            return response()->json(['message' => 'You didnt have a document yet'], 200);
        $update_document = $user->sponsorshipDocument->updateDocument()->create([
            'user_id' => $user->id,
            ...$request->only([
                'fixed_phone_number',
                'address',
                'academic_level',
                'job',
                'job_address',
                'available',
                'communicate_by_phone',
                'communicate_by_text_messages',
                'communicate_by_email',
                'communicate_with_the_sponsered_person',
                'participate_in_activities',
                'recognizing_way',
            ]),
        ]);
        return response()->json($update_document, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        //
    }
}
