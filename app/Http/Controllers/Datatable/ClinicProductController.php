<?php

namespace App\Http\Controllers\Datatable;

use App\Http\Controllers\Controller;
use App\Models\Clinic;
use App\Models\ClinicProduct;
use Illuminate\Http\Request;
use DataTables;

class ClinicProductController extends Controller
{
    public function index(Clinic $clinic)
    {
        $clinics = ClinicProduct::where('clinic_id', '=', $clinic->id)->get();

        return DataTables::of($clinics)
            ->addColumn('product_code', function ($clinic){
                return $clinic->product->product_code;
            })
            ->addColumn('product_category', function ($clinic){
                return $clinic->product->productCategory->name;
            })
            ->addColumn('product_name', function ($clinic){
                return $clinic->product->product_name;
            })
            ->addColumn('product_price', function ($clinic){
                return 'R ' . $clinic->price;
            })
            ->addColumn('edit', function ($clinic){
                return view('admin.clinic-stock.partials.actions', compact('clinic'));
            })
            ->addColumn('add_stock', function ($clinic){
                return view('admin.clinic-stock.partials.stock', compact('clinic'));
            })
            ->addColumn('view', function ($clinic){
                return view('admin.clinic-stock.partials.view', compact('clinic'));
            })
            ->make(true);
    }
}
