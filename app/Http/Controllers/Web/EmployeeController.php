<?php

namespace App\Http\Controllers\Web;

use App\Models\Employee;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\CreateEmployeeRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employee =  Employee::all();
        return response()->json($employee, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateEmployeeRequest $request)
    {
        DB::beginTransaction();
        try {
            $path = '';
            if ($request->file('image'))
                $path = $request->file('image')->store('Employee', 'public');
            $employee = Employee::create(array_merge($request->all(), ['image' => $path]));
            //notification
            DB::commit();
            return response()->json($employee, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            if (Storage::exists("public/" . $path))
                Storage::delete("public/" . $path);
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $employee = Employee::findOrFail($id);
        return response()->json($employee, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateEmployeeRequest $request, string $id)
    {
        DB::beginTransaction();
        try {
            $employee = Employee::findOrFail($id);
            if ($request->file('image')) {
                if ($employee->image) {
                    if (Storage::exists("public/" . $employee->image))
                        Storage::delete("public/" . $employee->image);
                }
                $path = $request->file('image')->store('Employee', 'public');
                $employee->update(array_merge($request->all(), ['image' => $path]));
            } else {
                $employee->update(array_merge($request->all()));
            }
            DB::commit();
            return response()->json($employee, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json($e->getMessage(), $e->getCode() ?: 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $employee = Employee::findOrFail($id);
            $image = $employee->image;
            $employee->delete();
            if ($image) {
                if (Storage::exists("public/" . $image))
                    Storage::delete("public/" . $image);
            }
            DB::commit();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json($e->getMessage(), $e->getCode() ?: 500);
        }
    }
}
