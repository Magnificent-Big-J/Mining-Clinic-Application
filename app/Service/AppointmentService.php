<?php


namespace App\Service;


use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Carbon\Carbon;

class AppointmentService
{
    public static function stats()
    {
        return [
            'today_appointments' => Appointment::where('status', '=', Appointment::ACCEPTED_STATUS)->where('appointment_date', '=', Carbon::now())->count() ,
            'upcoming_appointments' => Appointment::where('status', '=', Appointment::ACCEPTED_STATUS)->where('appointment_date', '>', Carbon::now())->count(),
            'doctors_count' => Doctor::count(),
            'patients_count' => Patient::count(),
        ];
    }
}
