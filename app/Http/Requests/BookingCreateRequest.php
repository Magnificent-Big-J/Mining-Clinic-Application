<?php

namespace App\Http\Requests;


use App\Mail\DoctorBooking;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Service\BookingService;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Mail;

class BookingCreateRequest extends FormRequest
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
            'doctor' => 'required',
        ];
    }
    public function createBooking()
    {
        if (BookingService::alreadyBooked($this->appointment_date, $this->timeSlot, $this->doctor)) {
            return [
                'appointment' => [],
                'created' => false,
                'patient' => $this->patient,
            ];
        } else {
           $appointment = Appointment::create([
                'patient_id'=> $this->patient,
                'doctor_id' => $this->doctor,
                'appointment_date' => Carbon::parse($this->appointment_date),
                'appointment_time'=> $this->timeSlot,
                'status' => Appointment::PENDING_STATUS
            ]);
            $doctor = Doctor::find($this->doctor);

            Mail::to($doctor->email)->send(new DoctorBooking($appointment));

            return [
                'appointment' => $appointment,
                'created' => true,
                'patient' => $this->patient,
            ];
        }

    }
}
