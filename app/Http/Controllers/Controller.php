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
        $order = $request->input('order', 'desc');
        $filter = $request->input('filter', 'id');
        $search = $request->input('search');

        if ($search) {
            if (strpos($filter, '.') !== false) {
                [$relation, $field] = explode('.', $filter);

                $query->whereHas($relation, function ($q) use ($field, $search) {
                    $q->where($field, 'like', '%' . $search . '%');
                });
            } else {
                // Otherwise, apply a normal where clause
                $query->where($filter, 'like', '%' . $search . '%');
            }
        }
        if (strpos($orderBy, '.') !== false) {
            [$relation, $field] = explode('.', $orderBy);
    
            // Get the relation instance
            $relationInstance = $query->getModel()->$relation();
            
            // Determine the type of relationship and get the correct keys
            if ($relationInstance instanceof \Illuminate\Database\Eloquent\Relations\BelongsTo) {
                // For BelongsTo, use the owner key (related model's primary key) and the foreign key
                $relatedTable = $relationInstance->getRelated()->getTable();
                $ownerKey = $relationInstance->getOwnerKeyName();
                $foreignKey = $relationInstance->getForeignKeyName();
            } else {
                throw new \Exception('Unsupported relationship type for ordering.');
            }
    
            // Join the related table and order by the related field
            $query->join($relatedTable, "{$relatedTable}.{$ownerKey}", '=', "{$query->getModel()->getTable()}.{$foreignKey}")
                  ->orderBy("{$relatedTable}.{$field}", $order);
        } else {
            $query->orderBy($orderBy, $order);
        }
    
        return $query->paginate($perPage);
    }
}
