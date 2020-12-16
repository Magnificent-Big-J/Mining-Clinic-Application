<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Doctor;
use App\Http\Requests\DoctorProductUpdateRequest;
use App\Http\Resources\DoctorProductResource;
use App\Models\DoctorProduct;
use App\Models\ProductStock;
use App\Service\DoctorProductService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpParser\Comment\Doc;

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
    public function storeDoctorProduct(Request $request)
    {
        $options = $request->get('doctorProducts');
        $doctor = $request->get('doctor');
        foreach ($options as $option) {

            if (! DoctorProductService::recordExists($doctor, $option)) {

             $doctorProduct = DoctorProduct::create([
                    'product_id' => $option,
                    'doctor_id' => $doctor
                ])->id;
             ProductStock::create([
                  'quantity' => 0,
                  'stock_date' => Carbon::now(),
                  'doctor_product_id' => $doctorProduct
                ]);
            }
        }

        return [
            'message'=> 'Doctor Product Successfully Added'
        ];
    }

    public function getDoctorProduct(DoctorProduct $doctorProduct)
    {
        return [
            'product_name' => $doctorProduct->product->product_name,
            'threshold' => $doctorProduct->threshold,
            'price' => $doctorProduct->price,
        ];
    }
    public function updateDoctorProduct(DoctorProduct $doctorProduct, DoctorProductUpdateRequest $request)
    {
        $request->updateDoctorProduct($doctorProduct);

        return [
          'message' => 'Successfully updated'
        ];
    }
    public function productName(DoctorProduct $doctorProduct)
    {
        return [
            'product_name' => $doctorProduct->product->product_name,
        ];
    }
}
