<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DoctorAppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::whereDate(
            'appointment_date', '>=', Carbon::now())
            ->whereNotIn('status', [Appointment::DECLINED_STATUS, Appointment::DONE_STATUS])
            ->where('doctor_id', '=', auth()->user()->doctor->id)->get();

        return view('doctor.appointments.index', compact('appointments'));
    }
    public function show(Appointment $appointment)
    {
        return  view('doctor.appointments.show', compact('appointment'));
    }
    public function doctorAppointments()
    {
        return view('doctor.historic-appointment.index');
    }
    public function patientPrescription(Appointment $appointment)
    {
       return view('doctor.prescriptions.show', compact('appointment'));
    }

}
