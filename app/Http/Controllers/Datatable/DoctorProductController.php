<?php

namespace App\Http\Controllers\Datatable;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\DoctorProduct;
use DataTables;

class DoctorProductController extends Controller
{
    public function doctorProduct(Doctor $doctor)
    {
        $doctorProducts = DoctorProduct::where('doctor_id', '=', $doctor->id)->get();

        return DataTables::of($doctorProducts)
            ->addIndexColumn()
            ->addColumn('product_code', function ($row){
                return $row->product->product_code;
            })
            ->addColumn('product_category', function ($row){
                return $row->product->productCategory->name;
            })
            ->addColumn('product_name', function ($row){
                return $row->product->product_name;
            })
            ->addColumn('product_price', function ($row){
                return 'R ' . $row->price;
            })
            ->addColumn('actions', function ($row){
                return view('admin.doctors.partials.doctor_product_actions', compact('row'));
            })
            ->rawColumns(['product_code','product_category','product_name','product_price','actions'])
            ->make(true);
    }
}
