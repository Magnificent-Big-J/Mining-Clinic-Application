<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingCreateRequest;
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

        $message = ($isCreated) ? 'Patient record successfully updated.' : 'Please select another timeslot, Doctor already been booked';
        session()->flash('success', $message);
        return redirect()->route('admin.patients.index');
    }
}