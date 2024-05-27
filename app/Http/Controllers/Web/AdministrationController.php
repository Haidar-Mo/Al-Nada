<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\CreateAccountRequest;
use App\Models\Administration;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdministrationController extends Controller
{
    /**
     * Display a listing of the employee.
     * @return JsonResponse
     */
    public function index()
    {

    }

    /**
     * Store a newly created employee in storage.
     * @param CreateEmployeeRequest $request
     * @return JsonResponse
     */
    public function store(CreateAccountRequest $request)
    {
       
    }

    /**
     * Display the specified employee.
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id)
    {
        
    }

    /**
     * Update the specified employee in storage.
     * @param CreateEmployeeRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(CreateAccountRequest $request, string $id)
    {
       
    }

    /**
     * remove employee data from storage.
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id)
    {
       
    }
}
