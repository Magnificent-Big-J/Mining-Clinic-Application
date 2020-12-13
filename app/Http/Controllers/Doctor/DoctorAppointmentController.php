<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class DoctorAppointmentController extends Controller
{
    public function show(Appointment $appointment)
    {
        return  view('doctor.appointments.show', compact('appointment'));
    }
}
