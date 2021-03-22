<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingCreateRequest;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function store(BookingCreateRequest $request)
    {
        $results = $request->createBooking();
        $isCreated = $results['created'];
        $appointment = $results['appointment'];
        $patient = $results['patient'];

        $shouldContinue = false;
        $url = null;
        $success = 'Please select another timeslot, Doctor already been booked.';
        if ($isCreated) {
            $shouldContinue = true;
            $url = route('admin.covid.screening',['appointment'=> $appointment->id, 'patient'=> $patient]);
            $success = 'Appointment booking is successfully created.';
        }

        return response()->json([
            'url' => $url,
            'shouldContinue' => $shouldContinue,
            'success' => $success,
        ], 200);
    }
}
