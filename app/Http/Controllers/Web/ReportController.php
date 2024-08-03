<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the reports
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 20);
        $orderBy = $request->input('order_by', 'id');
        $order = $request->input('order', 'asc');
        $filter = $request->input('filter', 'id');
        $search  = $request->input('search');

        $reports = Report::with('user')
            ->where($filter, 'LIKE', '%' . $search . '%')
            ->orderBy($orderBy, $order)
            ->paginate($perPage);
        return response()->json($reports);
    }

    /**
     * Display the specified report
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id)
    {
        $report = Report::with('user')->findOrFail($id);
        return response()->json($report);
    }

    /**
     * Remove the specified report from storage
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id)
    {
        $report = Report::findOrFail($id);
        $report->delete();
        return response()->json(null, 204);
    }
}
