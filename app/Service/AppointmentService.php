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
    public static function doctorStats()
    {
        return [
            'today_appointments' => Appointment::where('doctor_id', '=', auth()->user()->doctor->id)->where('status', '=', Appointment::ACCEPTED_STATUS)->whereDate('appointment_date', '=', Carbon::now())->count(),
            'upcoming_appointments' => Appointment::where('doctor_id', '=', auth()->user()->doctor->id)->whereDate('appointment_date', '>', Carbon::now())->count(),
            'completed_appointments' => Appointment::where('doctor_id', '=', auth()->user()->doctor->id)->where('status', '=', Appointment::DONE_STATUS)->count(),
        ];
    }
}
