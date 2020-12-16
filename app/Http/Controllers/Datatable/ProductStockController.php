<?php

namespace App\Http\Controllers\Datatable;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\ProductStock;
use App\Service\DoctorProductService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DataTables;

class ProductStockController extends Controller
{
    public function doctorProduct(Doctor $doctor, Request $request)
    {
        if (!empty($request->from_date) && !empty($request->to_date)) {
            $range = [
                Carbon::parse($request->from_date), Carbon::parse($request->to_date)
            ];
        } else {
            $range = [
                Carbon::now()->firstOfMonth(), Carbon::now()->lastOfMonth()
            ];
        }

        $productStocks = DoctorProductService::getData($range, $doctor->id);

        return DataTables::of($productStocks)
            ->addIndexColumn()
            ->addColumn('product_code', function ($row){
                return $row->doctorProduct->product->product_code;
            })
            ->addColumn('product_category', function ($row){
                return $row->doctorProduct->product->productCategory->name;
            })
            ->addColumn('product_name', function ($row){
                return $row->doctorProduct->product->product_name;
            })
            ->addColumn('product_price', function ($row){
                return 'R ' . $row->doctorProduct->price;
            })

            ->rawColumns(['product_code','product_category','product_name','product_price'])
            ->make(true);
    }
}
