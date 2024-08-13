<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function applyFilters(Request $request, $query)
    {
        $perPage = $request->input('per_page', 20);
        $orderBy = $request->input('order_by', 'created_at');
        $order = $request->input('order', 'asc');
        $filter = $request->input('filter', 'id');
        $search = $request->input('search');

        if ($search) {
            $query->where($filter, 'like', '%' . $search . '%');
        }

        return $query->orderBy($orderBy, $order)->paginate($perPage);
    }
}
