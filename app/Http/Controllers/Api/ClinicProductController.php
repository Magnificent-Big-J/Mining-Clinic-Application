<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DoctorProductUpdateRequest;
use App\Http\Requests\ProductStockCreateRequest;
use App\Models\ClinicProduct;
use App\Models\ProductStock;
use App\Service\ClinicProductService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ClinicProductController extends Controller
{
    public function show(ClinicProduct $clinicProduct)
    {

        $data =  [
            'product_threshold'=> $clinicProduct->threshold,
            'product_name'=> $clinicProduct->product->product_name,
            'product_code'=> $clinicProduct->product->product_code,
            'product_category'=> $clinicProduct->product->productCategory->name,
            'product_description'=> $clinicProduct->product->product_description,
            'product_unit'=> $clinicProduct->product->product_unit,
            'product_size'=> $clinicProduct->product->product_size,
            'product_price'=> 'R ' . $clinicProduct->price,
        ];


        return view('admin.clinic-stock.partials.show', compact('data'));

    }
    public function storeClinicProduct(Request $request)
    {
        $options = $request->get('clinicProducts');
        $clinic = $request->get('clinic');
        foreach ($options as $option) {

            if (!ClinicProductService::recordExists($clinic, $option)) {

                $clinicProduct = ClinicProduct::create([
                    'product_id' => $option,
                    'clinic_id' => $clinic
                ])->id;
                ProductStock::create([
                    'quantity' => 0,
                    'stock_date' => Carbon::now(),
                    'clinic_product_id' => $clinicProduct
                ]);
            }
        }

        return [
            'message'=> 'Mining Clinic Product Successfully Added'
        ];
    }

    public function getClinicProduct(ClinicProduct $clinicProduct )
    {

        return [
            'product_name' => "{$clinicProduct->product->product_name} {$clinicProduct->product->product_code}" ,
            'threshold' => $clinicProduct->threshold,
            'price' => $clinicProduct->price,
        ];
    }
    public function updateClinicProduct(ClinicProduct $clinicProduct, DoctorProductUpdateRequest $request): array
    {
        $request->updateDoctorProduct($clinicProduct);

        return [
            'message' => 'Successfully Updated'
        ];
    }
    public function productName(ClinicProduct $clinicProduct)
    {
        return [
            'product_name' => $clinicProduct->product->product_name,
        ];
    }

    public function storeStock(ProductStockCreateRequest $request, ClinicProduct $clinicProduct)
    {
        $message =  $request->createStock($clinicProduct);
        return [
            'message' => $message
        ];
    }
}
