<?php


namespace App\Service;

use App\Models\DoctorProduct;

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
}
