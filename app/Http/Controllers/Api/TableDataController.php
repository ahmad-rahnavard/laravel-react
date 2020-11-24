<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Datatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\TableDataRequest;

class TableDataController extends Controller
{
    /**
     * Get the authenticated User
     *
     * @param TableDataRequest $request
     *
     * @return array
     */
    public function index(TableDataRequest $request)
    {
        $file       = storage_path('app/table_data.json');
        $collection = collect(json_decode(file_get_contents($file), true));

        return (new Datatable(
            $collection,
            [0 => 'id', 2 => 'product_name', 3 => 'product_desc', 4 => 'quantity', 5 => 'price', 6 => 'category'],
            ['product_name', 'product_desc', 'category']
        ))->get();
    }
}
