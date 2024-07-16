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
    public function index()
    {
        $reports = Report::with('user')->get();
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
