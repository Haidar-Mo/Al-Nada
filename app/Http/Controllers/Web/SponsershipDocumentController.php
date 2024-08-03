<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\SponsershipDocument;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SponsershipDocumentController extends Controller
{
    /**
     * Display a listing of the Sponsership Documentations
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

        $documents = SponsershipDocument::with('user')
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
        $document = SponsershipDocument::with('user')->findOrFail($id);
        return response()->json($document, 200);
    }

    /**
     * Activate the specific Document
     * @param string $id The -id- of the document
     * @return JsonResponse
     */
    public function activate(string $id)
    {
        $document = SponsershipDocument::findorFail($id);
        $document->update(['active' => 1]);
        $document->user->update(['is_sponser' => 1]);
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
            $document = SponsershipDocument::findorFail($id);
            $document->update(['active' => 0]);

            // Deactivate the User from being a Sponsor
            $user = $document->user;
            $user->update(['is_sponser' => 0]);

            // Stop all active sponserships of the user and update their end_reason and end_date.
            $activated_sponserships = $user->sponserships()->where('active', 1)->get();
            $activated_sponserships->each(function ($sponsership) {
                $sponsership->update([
                    'active' => 0,
                    'end_date' => now(),
                    'end_reason' => 'ايقاف الكفيل'
                ]);
            });

            // Reject all requested sponserships of the user and update their status and reject_reason
            $unaccepted_sponserships = $user->sponserships()->where('status', 'انتظار')->get();
            $unaccepted_sponserships->each(function ($sponsership) {
                $sponsership->update([
                    'status' => 'مرفوض',
                    'reject_reason' => 'ايقاف كفيل'
                ]);
            });
            DB::commit();
            return response()->json([
                'document' => $document,
                'stopped sponserships' => $activated_sponserships,
                'rejected sponserships' => $unaccepted_sponserships
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SponsershipDocument $sponsershipDocument)
    {
        //
    }
}
