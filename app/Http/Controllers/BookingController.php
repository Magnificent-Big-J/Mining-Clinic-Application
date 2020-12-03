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
       $isCreated = $request->createBooking();

        $message = ($isCreated) ? 'Appointment booking is successfully created.' : 'Please select another timeslot, Doctor already been booked';
        session()->flash('success', $message);
        return redirect()->route('admin.appointments.index');
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
}
