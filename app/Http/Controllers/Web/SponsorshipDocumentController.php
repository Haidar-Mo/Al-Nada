<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\SponsorshipDocument;
use App\Models\SponsorshipDocumentUpdate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SponsorshipDocumentController extends Controller
{
    /**
     * Display a listing of the Sponsorship Documentations
     * @param Request $request => User filter input
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $query = SponsorshipDocument::with('user');
        $documents  = $this->applyFilters($request, $query);
        return response()->json($documents);
    }

    /**
     * Display the specified Document.
     * @param string $id => The ID of the Document
     * @return JsonResponse
     */
    public function show(string $id)
    {
        $document = SponsorshipDocument::with('user')->findOrFail($id);
        return response()->json($document, 200);
    }

    /**
     * Activate the specific Document
     * @param string $id The -id- of the document
     * @return JsonResponse
     */
    public function activate(string $id)
    {
        $document = SponsorshipDocument::findorFail($id);
        $document->update(['active' => 1]);
        $document->user->update(['is_sponsor' => 1]);
        return response()->json($document, 200);
    }


    /**
     * Deactivate the specific Document
     * @param string $id The -id- of the document
     * @return JsonResponse
     */
    public function deactivate(string $id)
    {
        DB::beginTransaction();
        try {
            // Deactive the Document
            $document = SponsorshipDocument::findorFail($id);
            $document->update(['active' => 0]);

            // Deactivate the User from being a Sponsor
            $user = $document->user;
            $user->update(['is_sponsor' => 0]);

            // Stop all active Sponsorships of the user and update their end_reason and end_date.
            $activated_sponsorships = $user->sponsorshipDocument()->where('active', 1)->get();
            $activated_sponsorships->each(function ($sponsorship) {
                $sponsorship->update([
                    'active' => 0,
                    'end_date' => now(),
                    'end_reason' => 'ايقاف الكفيل'
                ]);
            });

            // Reject all requested sponsorships of the user and update their status and reject_reason
            $unaccepted_sponsorships = $user->sponsorshipCase()->where('status', 'انتظار')->get();
            $unaccepted_sponsorships->each(function ($sponsorship) {
                $sponsorship->update([
                    'status' => 'مرفوض',
                    'reject_reason' => 'ايقاف كفيل'
                ]);
            });
            DB::commit();
            return response()->json([
                'document' => $document,
                'stopped sponsorships' => $activated_sponsorships,
                'rejected sponsorships' => $unaccepted_sponsorships
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function indexUpdateRequest(Request $request)
    {

        $query = SponsorshipDocumentUpdate::with('user');
        $documents = $this->applyFilters($request, $query);
        return response()->json($documents, 200);
    }

    public function showUpdateRequest(string $id)
    {
        $document = SponsorshipDocumentUpdate::with('user', 'document')->findOrFail($id);
        return response()->json($document, 200);
    }

    public function acceptDocumentUpdate(string $id)
    {
        DB::beginTransaction();
        try {

            $update_document = SponsorshipDocumentUpdate::with('user', 'document')->findOrFail($id);
            $document = $update_document->document;
            $document->update($update_document->only([
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
            ]));
            $update_document->update(['status' => 'مقبول']);
            DB::commit();
            return  response()->json($document, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function rejectDocumentUpdate(string $id)
    {
        $update_document = SponsorshipDocumentUpdate::with('user', 'document')->findOrFail($id);
        $update_document->update(['status' => 'مرفوض']);
        return  response()->json($update_document, 200);
    }
}
