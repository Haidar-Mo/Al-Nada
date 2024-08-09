<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\SponsorshipDocument;
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
        $perPage = $request->input('per_page', 20);
        $orderBy = $request->input('order_by', 'id');
        $order = $request->input('order', 'asc');
        $filter = $request->input('filter', 'id');
        $search  = $request->input('search');

        $documents = SponsorshipDocument::with('user')
            ->where($filter, 'LIKE', '%' . $search . '%')
            ->orderBy($orderBy, $order)
            ->paginate($perPage);

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
            $activated_sponsorships = $user->sponsorships()->where('active', 1)->get();
            $activated_sponsorships->each(function ($sponsorship) {
                $sponsorship->update([
                    'active' => 0,
                    'end_date' => now(),
                    'end_reason' => 'ايقاف الكفيل'
                ]);
            });

            // Reject all requested sponsorships of the user and update their status and reject_reason
            $unaccepted_sponsorships = $user->sponsorships()->where('status', 'انتظار')->get();
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
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SponsorshipDocument $sponsorshipDocument)
    {
        //
    }
}
