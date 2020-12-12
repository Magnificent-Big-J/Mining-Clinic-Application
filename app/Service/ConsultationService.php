<?php


namespace App\Service;


use App\Models\ConsultationFee;

class ConsultationService
{
    public static function recordExists(int $doctor, int $consultation) : bool
    {
        $consultationFee = ConsultationFee::where('consultation_id', '=', $consultation)
            ->where('doctor_id', '=', $doctor)
            ->first();

        if ($consultationFee) {
            return  true;
        }

        return  false;
    }
}
