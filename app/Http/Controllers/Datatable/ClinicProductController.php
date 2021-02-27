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
            ->addIndexColumn()
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
            ->addColumn('actions', function ($clinic){
                return view('admin.clinic-stock.partials.actions', compact('clinic'));
            })
            ->rawColumns(['product_code','product_category','product_name','product_price','actions'])
            ->make(true);
    }
}
