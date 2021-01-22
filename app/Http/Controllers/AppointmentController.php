<?php

namespace App\Http\Controllers;

use App\Mail\AppointmentCancelled;
use App\Mail\DoctorBooking;
use App\Mail\MedicalAidInvoince;
use App\Mail\PatientInvoice;
use App\Models\Appointment;
use App\Service\AppointmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.appointments.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function show(Appointment $appointment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function edit(Appointment $appointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Appointment $appointment)
    {
        $appointment->status = $request->status;
        $appointment->save();
        AppointmentService::sendEmail($appointment);
        if (intval($appointment->status) === Appointment::ACCEPTED_STATUS) {
            session()->flash('success','Appointment has been accepted');
        } else if (intval($appointment->status) === Appointment::DECLINED_STATUS) {
            session()->flash('success','Appointment has been declined');
        } else if (intval($appointment->status) === Appointment::DONE_STATUS) {
            if ($appointment->patient->has_medical_aid) {
                Mail::to($appointment->patient->medicalAid[0]->medical_email_address)->send(new MedicalAidInvoince($appointment, $appointment->patient->medicalAid));
            } else {
                Mail::to($appointment->patient->email_address)->send(new PatientInvoice($appointment));
            }
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appointment $appointment)
    {
        Mail::to($appointment->doctor->email)->send(new AppointmentCancelled($appointment));
        session()->flash('success','Appointment has been deleted');

        $appointment->delete();

        return redirect()->back();
    }
}
