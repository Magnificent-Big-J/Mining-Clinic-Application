<?php

use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AppointmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $appointments = [
            [
                'patient_id' => 1,
                'doctor_id' => 1,
                'appointment_date' => Carbon::now(),
                'appointment_time' => Carbon::now()->addHours(1),
                'status' => Appointment::PENDING_STATUS
            ],
            [
                'patient_id' => 2,
                'doctor_id' => 1,
                'appointment_date' => Carbon::now(),
                'appointment_time' => Carbon::now()->addHours(2),
                'status' => Appointment::PENDING_STATUS
            ],
            [
                'patient_id' => 3,
                'doctor_id' => 1,
                'appointment_date' => Carbon::now(),
                'appointment_time' => Carbon::now()->addHours(3),
                'status' => Appointment::PENDING_STATUS
            ],
            [
                'patient_id' => 4,
                'doctor_id' => 1,
                'appointment_date' => Carbon::now(),
                'appointment_time' => Carbon::now()->addHours(4),
                'status' => Appointment::PENDING_STATUS
            ],
            [
                'patient_id' => 1,
                'doctor_id' => 1,
                'appointment_date' => Carbon::now(),
                'appointment_time' => Carbon::now()->addHours(5),
                'status' => Appointment::PENDING_STATUS
            ]
        ];

        foreach ($appointments as $appointment) {
            Appointment::create($appointment);
        }
    }
}
