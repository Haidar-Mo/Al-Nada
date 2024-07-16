<?php

namespace App\Http\Controllers\Mobile;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Display a listing of the reports
     * @return JsonResponse
     */
    public function index()
    {
        $user = User::find(Auth::user()->id);
        $reports = $user->report()->get();
        return response()->json($reports, 200);
    }

    /**
     * Display the specified report
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id)
    {
        $user = User::find(Auth::user()->id);
        $report = $user->report()->findOrFail($id);
        return response()->json($report, 200);
    }

    /**
     * Store a newly created report in storage
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $request->validate([
            'description' => ['required']
        ]);
        $report = $user->report()->create($request->only('description'));
        return response()->json($report, 201);
    }
}
