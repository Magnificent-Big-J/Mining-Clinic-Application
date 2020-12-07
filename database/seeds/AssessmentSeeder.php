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
            array('patient_id' => 1, 'doctor_id' => 1, 'appointment_date' => Carbon::now()->subMonths(4),'appointment_time' => Carbon::now()->subMonths(4)->addHours(1),'status' => Appointment::ACCEPTED_STATUS),
            array('patient_id' => 1, 'doctor_id' => 1, 'appointment_date' => Carbon::now()->subMonths(2),'appointment_time' => Carbon::now()->subMonths(2)->addHours(1),'status' => Appointment::ACCEPTED_STATUS),
            array('patient_id' => 1, 'doctor_id' => 1, 'appointment_date' => Carbon::now()->subDays(6),'appointment_time' => Carbon::now()->subDay(6)->addHours(1),'status' => Appointment::ACCEPTED_STATUS),
            array('patient_id' => 1, 'doctor_id' => 1, 'appointment_date' => Carbon::now()->subDays(2),'appointment_time' => Carbon::now()->subDay(2)->addHours(1),'status' => Appointment::ACCEPTED_STATUS),
        );

        foreach ($appointments as $appointment) {
            Appointment::create($appointment);
        }


        $assessments = array(
            array('consultation_fee_id' => 1, 'appointment_id'=>1, 'assessment_date' => Carbon::now()->subMonths(4)),
            array('consultation_fee_id' => 2, 'appointment_id'=>1, 'assessment_date' => Carbon::now()->subMonths(4)),
            array('consultation_fee_id' => 3, 'appointment_id'=>5, 'assessment_date' => Carbon::now()->subMonths(2)),
            array('consultation_fee_id' => 1, 'appointment_id'=>5, 'assessment_date' => Carbon::now()->subMonths(2)),
            array('consultation_fee_id' => 3, 'appointment_id'=>6, 'assessment_date' => Carbon::now()->subDays(6)),
            array('consultation_fee_id' => 4, 'appointment_id'=>6, 'assessment_date' => Carbon::now()->subDays(6)),
            array('consultation_fee_id' => 1, 'appointment_id'=>7, 'assessment_date' => Carbon::now()->subDays(2)),
            array('consultation_fee_id' => 2, 'appointment_id'=>7, 'assessment_date' => Carbon::now()->subDays(2)),
            array('consultation_fee_id' => 6, 'appointment_id'=>8, 'assessment_date' => Carbon::now()->subDays(2)),
            array('consultation_fee_id' => 7, 'appointment_id'=>8, 'assessment_date' => Carbon::now()->subDays(2)),
        );

        foreach ($assessments as $assessment) {
            AppointmentAssessment::create($assessment);
        }

    }
}
