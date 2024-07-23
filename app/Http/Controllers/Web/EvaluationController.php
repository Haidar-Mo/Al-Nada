<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\EvaluationRequest;
use App\Models\Employee;
use App\Models\Evaluation;
use Illuminate\Http\JsonResponse;

class EvaluationController extends Controller
{
    /**
     * Display a listing of the Evaluation.
     * @return JsonResponse
     */
    public function index()
    {
        $evaluations = Evaluation::with(['employee'])->get();
        return response()->json($evaluations, 200);
    }

    /**
     * Display the specified Evaluation.
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id)
    {
        $evaluation = Evaluation::with(['employee'])->findOrFail($id);
        return response()->json($evaluation, 200);
    }

    /**
     * Store a newly created Evaluation in storage.
     * @param EvaluationRequest $request
     * @param stirng $id
     * @return JsonResponse
     */
    public function store(EvaluationRequest $request, string $id)
    {
        $employee = Employee::findOrFail($id);
        $total_score = array_sum($request->all());
        $evaluation = $employee->evaluation()
            ->create(array_merge(
                $request->all(),
                ['total_score' => $total_score]
            ));
        return response()->json($evaluation, 201);
    }



    /**
     * Update the specified Evaluation in storage.
     * @param EvaluationRequest $request
     * @param stirng $id
     * @return JsonResponse
     */
    public function update(EvaluationRequest $request, string $id)
    {
        $evaluation = Evaluation::findOrFail($id);
        $evaluation->update($request->all());

        return response()->json($evaluation, 200);
    }

    /**
     * Remove the specified Evaluation from storage.
     * @return JsonResponse
     */
    public function destroy(string $id)
    {
        $evaluation = Evaluation::findOrFail($id);
        $evaluation->delete();

        return response()->json(null, 204);
    }
}
