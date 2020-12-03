<?php

namespace App\Http\Requests;

use App\Mail\AppointmentReschedule;
use App\Service\BookingService;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Mail;

class BookingUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'appointment_date' => 'required',
        ];
    }
    public function updateBooking($appointment)
    {
        if (BookingService::alreadyBooked($this->appointment_date, $this->timeSlot, $appointment->doctor->id)) {
            return false;
        } else {

            $appointment->appointment_date = Carbon::parse($this->appointment_date);
            $appointment->appointment_time = $this->timeSlot;
            $appointment->save();

            Mail::to($appointment->doctor->email)->send(new AppointmentReschedule($appointment));

            return true;
        }
    }
}
