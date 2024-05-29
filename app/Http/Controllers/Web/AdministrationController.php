<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\CreateAccountRequest;
use App\Models\Administration;
use Illuminate\Http\JsonResponse;


class AdministrationController extends Controller
{
    /**
     * Display a listing of the employee accounts.
     * @return JsonResponse
     */
    public function index()
    {
        $accounts = Administration::all();
        return response()->json($accounts, 200);
    }

    /**
     * Store a newly created employee account in storage.
     * @param CreateEmployeeRequest $request
     * @return JsonResponse
     */
    public function store(CreateAccountRequest $request)
    {
        $account = Administration::create($request->all());
        return response()->json($account, 201);
    }

    /**
     * Display the specified employee account.
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id)
    {
        $account = Administration::findOrFail($id);
        return response()->json($account, 200);
    }

    /**
     * Update the specified employee account in storage.
     * @param CreateEmployeeRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(CreateAccountRequest $request, string $id)
    {
        $account = Administration::findOrFail($id);
        $account->update($request->all());
        return response()->josn($account, 200);
    }

    /**
     * remove employee account from storage.
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id)
    {
        $account = Administration::findOrFail($id);
        $account->delete();
        return response()->json(null, 204);
    }
}
