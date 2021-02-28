<?php


namespace App\Service\Doctor;


use App\Models\ConsultationFee;
use App\Models\Doctor;

class ConsultationFeeService
{
    public function consultationFees(Doctor $doctor)
    {
       return ConsultationFee::where('doctor_id', '=', $doctor->id)->get();
    }
}
