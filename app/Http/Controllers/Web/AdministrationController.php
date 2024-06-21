<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\CreateAccountRequest;
use App\Models\Administration;
use App\Models\Employee;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdministrationController extends Controller
{
    /**
     * Display a listing of the employee accounts.
     * @return JsonResponse
     */
    public function index()
    {
        $accounts = Administration::with('employee', 'roles')->get();
        $formattedUsers = $accounts->map(function ($accounts) {
            return [
                'id' => $accounts->id,
                'name' => $accounts->user_name,
                'employee' => $accounts->employee,
                'roles' => $accounts->roles->pluck('name'), // Assuming you want only role names
            ];
        });
        return response()->json($formattedUsers, 200);
    }

    /**
     * Store a newly created employee account in storage.
     * @param CreateEmployeeRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function store(CreateAccountRequest $request, string $id)
    {
        DB::beginTransaction();
        try {
            $account = Employee::findOrFail($id)->account()->create($request->all());
            $account->assignRole($request->role);
            $account->load('roles');
            $formatedResponse =  [
                'id' => $account->id,
                'name' => $account->user_name,
                'employee' => $account->employee,
                'roles' => $account->roles->pluck('name'), // Assuming you want only role names
            ];
            DB::commit();
            return response()->json($formatedResponse, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified employee account.
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id)
    {
        $account = Administration::with('employee', 'roles')->findOrFail($id);
        $formattedUsers =
            [
                'id' => $account->id,
                'name' => $account->user_name,
                'employee' => $account->employee,
                'roles' => $account->roles->pluck('name'),
            ];

        return response()->json($formattedUsers, 200);
    }

    /**
     * Update the specified employee account name in storage.
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function updateUserName(Request $request, string $id)
    {
        $request->validate([
            'user_name' => ['required', 'unique:administrations,user_name,' . $id . ',id'],
        ]);
        $account = Administration::findOrFail($id);
        $account->update($request->only('user_name'));
        $account->load('roles');
        $formatedResponse =  [
            'id' => $account->id,
            'name' => $account->user_name,
            'employee' => $account->employee,
            'roles' => $account->roles->pluck('name'), // Assuming you want only role names
        ];
        return response()->json($formatedResponse, 200);
    }
    /**
     * Update the specified employee account password in storage.
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function updatepassword(Request $request, string $id)
    {
        $request->validate([
            'password' => ['required', 'min:6'],
        ]);
        $account = Administration::findOrFail($id);
        $account->update($request->only('password'));
        $account->load('roles');
        $formatedResponse =  [
            'id' => $account->id,
            'name' => $account->user_name,
            'employee' => $account->employee,
            'roles' => $account->roles->pluck('name'), // Assuming you want only role names
        ];
        return response()->json($formatedResponse, 200);
    }
    /**
     * Update the specified employee account role in storage.
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    public function updateRole(Request $request, string $id)
    {
        $request->validate([
            'role' => ['required', 'in:admin,employee'],
        ]);
        $account = Administration::findOrFail($id);
        $account->syncRoles($request->role);
        $account->load('roles');
        $formatedResponse =  [
            'id' => $account->id,
            'name' => $account->user_name,
            'employee' => $account->employee,
            'roles' => $account->roles->pluck('name'), // Assuming you want only role names
        ];
        return response()->json($formatedResponse, 200);
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
