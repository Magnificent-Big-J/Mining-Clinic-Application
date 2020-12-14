<?php

namespace App\Http\Controllers\Datatable;

use App\Http\Controllers\Controller;
use App\Models\Product;
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
                return view('admin.products.category.partials.actions', compact('row'));
            })
            ->rawColumns(['actions'])
            ->make(true);
    }
    public function product()
    {
        $products = Product::all();

        return DataTables::of($products)
            ->addIndexColumn()
            ->addColumn('category', function ($row){
                return $row->productCategory->name;
            })
            ->addColumn('actions', function ($row){
                return view('admin.products.product.partials.actions', compact('row'));
            })
            ->rawColumns(['category', 'actions'])
            ->make(true);
    }
}
