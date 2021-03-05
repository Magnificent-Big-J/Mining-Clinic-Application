<?php

use App\Models\Appointment;
use App\Models\AppointmentAssessment;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AssessmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $appointments = array(
            array('clinic_id' => rand(1,4), 'patient_id' => rand(1,10), 'doctor_id' =>  rand(1,23), 'appointment_date' => Carbon::now()->subMonths(rand(1,4)),'appointment_time' => Carbon::now()->subMonths(rand(1,4))->addHours(rand(1,10)),'status' => Appointment::ACCEPTED_STATUS),
            array('clinic_id' => rand(1,4),'patient_id' => rand(1,10), 'doctor_id' => rand(1,23), 'appointment_date' => Carbon::now()->subMonths(rand(1,4)),'appointment_time' => Carbon::now()->subMonths(rand(1,4))->addHours(rand(1,10)),'status' => Appointment::ACCEPTED_STATUS),
            array('clinic_id' => rand(1,4),'patient_id' =>  rand(1,10), 'doctor_id' => rand(1,23), 'appointment_date' => Carbon::now()->subDays(rand(1,10)),'appointment_time' => Carbon::now()->subDay(rand(1,10))->addHours(rand(1,10)),'status' => Appointment::ACCEPTED_STATUS),
            array('clinic_id' => rand(1,4),'patient_id' =>  rand(1,10), 'doctor_id' => rand(1,23), 'appointment_date' => Carbon::now()->subDays(rand(1,10)),'appointment_time' => Carbon::now()->subDay(rand(1,10))->addHours(rand(1,10)),'status' => Appointment::ACCEPTED_STATUS),
        );

        foreach ($appointments as $appointment) {
            Appointment::create($appointment);
        }


        $assessments = array(
            array('consultation_fee_id' => 1, 'appointment_id'=>1, 'assessment_date' => Carbon::now()->subMonths(rand(1,4))),
            array('consultation_fee_id' => 2, 'appointment_id'=>1, 'assessment_date' => Carbon::now()->subMonths(rand(1,4))),
            array('consultation_fee_id' => 3, 'appointment_id'=>5, 'assessment_date' => Carbon::now()->subMonths(rand(1,4))),
            array('consultation_fee_id' => 1, 'appointment_id'=>5, 'assessment_date' => Carbon::now()->subMonths(rand(1,4))),
            array('consultation_fee_id' => 3, 'appointment_id'=>6, 'assessment_date' => Carbon::now()->subDays(rand(1,4))),
            array('consultation_fee_id' => 4, 'appointment_id'=>6, 'assessment_date' => Carbon::now()->subDays(rand(1,4))),
            array('consultation_fee_id' => 1, 'appointment_id'=>7, 'assessment_date' => Carbon::now()->subDays(rand(1,4))),
            array('consultation_fee_id' => 2, 'appointment_id'=>7, 'assessment_date' => Carbon::now()->subDays(rand(1,4))),
            array('consultation_fee_id' => 6, 'appointment_id'=>8, 'assessment_date' => Carbon::now()->subDays(rand(1,4))),
            array('consultation_fee_id' => 7, 'appointment_id'=>8, 'assessment_date' => Carbon::now()->subDays(rand(1,4))),
        );

        foreach ($assessments as $assessment) {
            AppointmentAssessment::create($assessment);
        }

    }
}
