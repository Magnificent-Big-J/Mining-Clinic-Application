<?php

namespace App\Http\Requests;


use App\Jobs\DoctorAppointmentBooking;
use App\Jobs\PatientAppointmentBooking;
use App\Mail\DoctorBooking;
use App\Mail\PatientBooking;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Service\BookingService;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
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
            'clinic' => 'required',
            'timeSlot' => 'required',
        ];
    }
    public function createBooking(): ?array
    {
        $doctor = Doctor::find($this->doctor);
        $patient = Patient::find($this->patient);

        if (BookingService::alreadyBooked($this->appointment_date, $this->timeSlot.":00", $this->doctor)) {
            return [
                'appointment' => [],
                'created' => false,
                'patient' => $this->patient,
                'success' => "Doctor is already been booked for {$this->appointment_date} ",
            ];
        } /*else if(BookingService::patientAlreadyBooked($this->appointment_date, $this->patient )) {
            return [
                'appointment' => [],
                'created' => false,
                'patient' => $this->patient,
                'success' => "Booking appointment for the patient for {$this->appointment_date}  already exists"
            ];
        }*/  else {

           $appointment = Appointment::create([
                'patient_id'=> $this->patient,
                'doctor_id' => $this->doctor,
                'appointment_date' => Carbon::parse($this->appointment_date),
                'appointment_time'=> $this->timeSlot,
                'status' => Appointment::PENDING_STATUS,
               'clinic_id' => $this->clinic,
            ]);

            if (!$doctor->patients()->where('patients.id', '=', $patient->id)->first()) {
                $doctor->patients()->attach([$patient->id]);
            }

            DoctorAppointmentBooking::dispatch($appointment, $doctor->email);
            PatientAppointmentBooking::dispatch($appointment, $patient->email_address);

            return [
                'appointment' => $appointment,
                'created' => true,
                'patient' => $this->patient,
                'success' => 'Appointment booking is successfully created.'
            ];
        }

    }
}
