<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingCreateRequest;
use App\Http\Requests\BookingUpdateRequest;
use App\Models\Appointment;
use App\Models\Patient;
use App\Service\BookingService;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function booking(Request $request)
    {
        $patient = Patient::find($request->patient);
        $timeSlots = BookingService::timeSlots();

        return view('admin.booking.booking', compact('patient', 'timeSlots'));
    }
    public function store(BookingCreateRequest $request)
    {
       $results = $request->createBooking();
       $isCreated = $results['created'];
       $appointment = $results['appointment'];
       $patient = $results['patient'];


        if ($isCreated) {

            session()->flash('success', 'Appointment booking is successfully created.');
            return redirect()->route('admin.covid.screening',['appointment'=> $appointment->id, 'patient'=> $patient]);
        }

        session()->flash('success', 'Please select another timeslot, Doctor already been booked.');

        return redirect()->back();
    }
    public function reschedule(Appointment $appointment)
    {
        $timeSlots = BookingService::timeSlots();
        return view('admin.booking.reschedule', compact('appointment', 'timeSlots'));
    }
    public function update(BookingUpdateRequest $request, Appointment $appointment)
    {

        $isUpdated = $request->updateBooking($appointment);
        if ($isUpdated)
        {
            session()->flash('success', 'Appointment booking is successfully rescheduled');
            return redirect()->route('admin.appointments.index');
        } else {
            session()->flash('success', 'Please select another timeslot, Doctor already been booked');
            return  redirect()->back();
        }
    }
    public function doctorUnbookedSlots(Request $request)
    {
        $timeSlots = BookingService::unbookedSlots($request->doctor, $request->appointment_date);

        return view('admin.booking.time_slots', compact('timeSlots'));
    }
}
