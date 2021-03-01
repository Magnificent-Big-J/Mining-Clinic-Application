<?php


namespace App\Service;

use App\Models\ClinicProduct;

use App\Models\ProductStock;
use Carbon\Carbon;

class ClinicProductService
{
    public static function recordExists(int $clinic, int $product) : bool
    {
        $doctorProduct = ClinicProduct::where('product_id', '=', $product)
            ->where('clinic_id', '=', $clinic)
            ->first();

        if ($doctorProduct) {
            return  true;
        }

        return  false;
    }
    public static function stockCaptured(string $date, int $product): bool
    {
        $productStock = ProductStock::where('clinic_product_id', '=', $product)
            ->where('stock_date', '=', Carbon::parse($date))
            ->first();

        if ($productStock) {
            return  true;
        }

        return  false;
    }
    public static function getData(array $range, int $doctor)
    {
       return  ProductStock::whereHas('clinicProduct', function ($query) use($doctor){
            $query->where('clinic_id', '=', $doctor);
        })
            ->whereBetween('stock_date', $range)
            ->get();
    }
}
