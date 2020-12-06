<?php

use App\Models\ConsultationFee;
use Illuminate\Database\Seeder;

class DoctorConsultationFeesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $consultationFees = array(
            array('consultation_fee'=> rand(150,1000), 'doctor_id' => 1, 'consultation_id' => 1),
            array('consultation_fee'=> rand(150,1000), 'doctor_id' => 1, 'consultation_id' => 2),
            array('consultation_fee'=> rand(150,1000), 'doctor_id' => 1, 'consultation_id' => 4),
            array('consultation_fee'=> rand(150,1000), 'doctor_id' => 1, 'consultation_id' => 10),
            array('consultation_fee'=> rand(150,1000), 'doctor_id' => 1, 'consultation_id' => 16),
            array('consultation_fee'=> rand(150,1000), 'doctor_id' => 1, 'consultation_id' => 20),
            array('consultation_fee'=> rand(150,1000), 'doctor_id' => 1, 'consultation_id' => 11),
        );
        foreach ($consultationFees as $consultationFee) {
            ConsultationFee::create($consultationFee);
        }
    }
}
