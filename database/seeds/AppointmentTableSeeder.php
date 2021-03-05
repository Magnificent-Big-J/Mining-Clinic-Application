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
                'status' => Appointment::PENDING_STATUS,
                'clinic_id' => 1,
            ],
            [
                'patient_id' => 2,
                'doctor_id' => 1,
                'appointment_date' => Carbon::now(),
                'appointment_time' => Carbon::now()->addHours(2),
                'status' => Appointment::PENDING_STATUS,
                'clinic_id' => 1,
            ],
            [
                'patient_id' => 3,
                'doctor_id' => 1,
                'appointment_date' => Carbon::now()->addDay(2),
                'appointment_time' => Carbon::now()->addDay(2)->addHours(3),
                'status' => Appointment::PENDING_STATUS,
                'clinic_id' => 1,
            ],
            [
                'patient_id' => 4,
                'doctor_id' => 1,
                'appointment_date' => Carbon::now()->addDay(3),
                'appointment_time' => Carbon::now()->addDay(3)->addHours(4),
                'status' => Appointment::PENDING_STATUS,
                'clinic_id' => 1,
            ],
            [
                'patient_id' => 1,
                'doctor_id' => 1,
                'appointment_date' => Carbon::now(),
                'appointment_time' => Carbon::now()->addHours(5),
                'status' => Appointment::PENDING_STATUS,
                'clinic_id' => 1,
            ],
            [
                'patient_id' => rand(1, 10),
                'doctor_id' => rand(1, 10),
                'appointment_date' => Carbon::now(),
                'appointment_time' => Carbon::now()->addHours(5),
                'status' => Appointment::PENDING_STATUS,
                'clinic_id' => 1,
            ],
            [
                'patient_id' =>  rand(1, 10),
                'doctor_id' =>  rand(1, 10),
                'appointment_date' => Carbon::now()->addDay(rand(1,10)),
                'appointment_time' => Carbon::now()->addDay(rand(1,10))->addHours(rand(1,8)),
                'status' => Appointment::PENDING_STATUS,
                'clinic_id' => 1,
            ],
            [
                'patient_id' => rand(1, 10),
                'doctor_id' => rand(1,10),
                'appointment_date' => Carbon::now()->addDay(rand(1,10)),
                'appointment_time' => Carbon::now()->addDay(rand(1,10))->addHours(rand(1,8)),
                'status' => Appointment::PENDING_STATUS,
                'clinic_id' => 1,
            ],
            [
                'patient_id' =>  rand(1, 10),
                'doctor_id' =>  rand(1, 10),
                'appointment_date' => Carbon::now()->addDay(rand(1,10)),
                'appointment_time' => Carbon::now()->addDay(rand(1,10))->addHours(rand(1,8)),
                'status' => Appointment::PENDING_STATUS,
                'clinic_id' => 1,
            ],
            [
                'patient_id' =>  rand(1, 10),
                'doctor_id' =>  rand(1, 10),
                'appointment_date' => Carbon::now()->addDay(rand(1,10)),
                'appointment_time' => Carbon::now()->addDay(rand(1,10))->addHours(rand(1,8)),
                'status' => Appointment::PENDING_STATUS,
                'clinic_id' => 1,
            ],
            [
                'patient_id' =>  rand(1, 10),
                'doctor_id' =>  rand(1, 10),
                'appointment_date' => Carbon::now()->addDay(rand(1,10)),
                'appointment_time' => Carbon::now()->addDay(rand(1,10))->addHours(rand(1,8)),
                'status' => Appointment::PENDING_STATUS,
                'clinic_id' => 1,
            ],
            [
                'patient_id' => rand(1, 10),
                'doctor_id' =>  rand(1, 10),
                'appointment_date' => Carbon::now()->addDay(rand(1,10)),
                'appointment_time' => Carbon::now()->addDay(rand(1,10))->addHours(rand(1,8)),
                'status' => Appointment::PENDING_STATUS,
                'clinic_id' => 1,
            ],
            [
                'patient_id' =>  rand(1, 10),
                'doctor_id' =>  rand(1, 10),
                'appointment_date' => Carbon::now()->addDay(rand(1,10)),
                'appointment_time' => Carbon::now()->addDay(rand(1,10))->addHours(rand(1,8)),
                'status' => Appointment::PENDING_STATUS,
                'clinic_id' => 1,
            ],
            [
                'patient_id' =>  rand(1, 10),
                'doctor_id' =>  rand(1, 10),
                'appointment_date' => Carbon::now()->addDay(rand(1,10)),
                'appointment_time' => Carbon::now()->addDay(rand(1,10))->addHours(rand(1,8)),
                'status' => Appointment::PENDING_STATUS,
                'clinic_id' => 1,
            ],
            [
                'patient_id' => rand(1, 10),
                'doctor_id' => rand(1, 10),
                'appointment_date' => Carbon::now()->addDay(rand(1,10)),
                'appointment_time' => Carbon::now()->addDay(rand(1,10))->addHours(rand(1,8)),
                'status' => Appointment::PENDING_STATUS,
                'clinic_id' => 1,
            ],
            [
                'patient_id' =>  rand(1, 10),
                'doctor_id' =>  rand(1, 10),
                'appointment_date' => Carbon::now()->addDay(rand(1,10)),
                'appointment_time' => Carbon::now()->addDay(rand(1,10))->addHours(rand(1,8)),
                'status' => Appointment::PENDING_STATUS,
                'clinic_id' => 1,
            ],
            [
                'patient_id' =>  rand(1, 10),
                'doctor_id' =>  rand(1, 10),
                'appointment_date' => Carbon::now()->addDay(rand(1,10)),
                'appointment_time' => Carbon::now()->addDay(rand(1,10))->addHours(rand(1,8)),
                'status' => Appointment::PENDING_STATUS,
                'clinic_id' => 1,
            ],
            [
                'patient_id' =>  rand(1, 10),
                'doctor_id' =>  rand(1, 10),
                'appointment_date' => Carbon::now()->addDay(rand(1,10)),
                'appointment_time' => Carbon::now()->addDay(rand(1,10))->addHours(rand(1,8)),
                'status' => Appointment::PENDING_STATUS,
                'clinic_id' => 1,
            ],
            [
                'patient_id' =>  rand(1, 10),
                'doctor_id' =>  rand(1, 10),
                'appointment_date' => Carbon::now()->addDay(rand(1,10)),
                'appointment_time' => Carbon::now()->addDay(rand(1,10))->addHours(rand(1,8)),
                'status' => Appointment::PENDING_STATUS,
                'clinic_id' => 1,
            ],
            [
                'patient_id' =>  rand(1, 10),
                'doctor_id' =>  rand(1, 10),
                'appointment_date' => Carbon::now()->addDay(rand(1,10)),
                'appointment_time' => Carbon::now()->addDay(rand(1,10))->addHours(rand(1,8)),
                'status' => Appointment::PENDING_STATUS,
                'clinic_id' => 1,
            ],
            [
                'patient_id' => rand(1, 10),
                'doctor_id' => rand(1, 10),
                'appointment_date' => Carbon::now()->addDay(rand(1,10)),
                'appointment_time' => Carbon::now()->addDay(rand(1,10))->addHours(rand(1,8)),
                'status' => Appointment::PENDING_STATUS,
                'clinic_id' => 1,
            ],
            [
                'patient_id' =>  rand(1, 10),
                'doctor_id' =>  rand(1, 10),
                'appointment_date' => Carbon::now()->addDay(rand(1,10)),
                'appointment_time' => Carbon::now()->addDay(rand(1,10))->addHours(rand(1,8)),
                'status' => Appointment::PENDING_STATUS,
                'clinic_id' => 1,
            ],
        ];

        foreach ($appointments as $appointment) {
            Appointment::create($appointment);
        }
        //$apps = factory(Appointment::class, 400)->create();
    }
}
