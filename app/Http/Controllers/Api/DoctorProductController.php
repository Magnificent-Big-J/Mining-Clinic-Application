<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DoctorProductResource;
use App\Models\DoctorProduct;
use Illuminate\Http\Request;

class DoctorProductController extends Controller
{
    public function show(DoctorProduct $doctorProduct)
    {

        $data =  [
            'product_threshold'=> $doctorProduct->threshold,
            'product_name'=> $doctorProduct->product->product_name,
            'product_code'=> $doctorProduct->product->product_code,
            'product_category'=> $doctorProduct->product->productCategory->name,
            'product_description'=> $doctorProduct->product->product_description,
            'product_unit'=> $doctorProduct->product->product_unit,
            'product_size'=> $doctorProduct->product->product_size,
            'product_price'=> 'R ' . $doctorProduct->price,
        ];


        return view('admin.doctors.partials.show', compact('data'));
    }
}
