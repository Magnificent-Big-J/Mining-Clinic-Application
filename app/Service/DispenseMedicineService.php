<?php


namespace App\Service;


use App\Models\DoctorProduct;

class DispenseMedicineService
{
    public static function calculate(int $doctorProductId, int $quantity): array
    {
        $doctorProduct = DoctorProduct::find($doctorProductId);
        $data = [
            'quantity' => 0,
            'shouldCount' => false
        ];
        if ($doctorProduct->quantity >= $quantity) {
            $doctorProduct->quantity -= $quantity;
            $doctorProduct->save();
            $data = [
                'quantity' => $quantity,
                'shouldCount' => true
            ];
        }
        return $data;
    }
}
