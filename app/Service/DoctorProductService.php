<?php


namespace App\Service;

use App\Models\DoctorProduct;
use App\Models\ProductStock;
use Carbon\Carbon;

class DoctorProductService
{
    public static function recordExists(int $doctor, int $product) : bool
    {
        $doctorProduct = DoctorProduct::where('product_id', '=', $product)
            ->where('doctor_id', '=', $doctor)
            ->first();

        if ($doctorProduct) {
            return  true;
        }

        return  false;
    }
    public static function stockCaptured(string $date, int $product)
    {
        $productStock = ProductStock::where('doctor_product_id', '=', $product)
            ->where('stock_date', '=', Carbon::parse($date))
            ->first();

        if ($productStock) {
            return  true;
        }

        return  false;
    }
}
