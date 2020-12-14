<?php

namespace App\Http\Controllers\Datatable;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use DataTables;

class ProductDatatableController extends Controller
{
    public function productCategories()
    {
        $categories = ProductCategory::all();

        return DataTables::of($categories)
            ->addIndexColumn()
            ->addColumn('actions', function ($row){
                return view('admin.category.partials.actions', compact('row'));
            })
            ->rawColumns(['actions'])
            ->make(true);
    }
}
