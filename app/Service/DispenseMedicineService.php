<?php


namespace App\Service;


use App\Models\ClinicProduct;


class DispenseMedicineService
{
    public static function calculate(int $clinicProductId, int $quantity): array
    {
        $clinicProduct = ClinicProduct::find($clinicProductId);
        $data = [
            'quantity' => 0,
            'shouldCount' => false
        ];
        if ($clinicProduct->quantity >= $quantity) {
            $clinicProduct->quantity -= $quantity;
            $clinicProduct->save();
            $data = [
                'quantity' => $quantity,
                'shouldCount' => true
            ];
        }
        return $data;
    }
}
