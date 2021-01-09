<?php

namespace App\Http\Requests;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Document;
use App\Models\Referral;
use App\Service\AppointmentFileService;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class ReferralCreateRequest extends FormRequest
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
            'refer_to' => 'required',
            'referral_reason' => 'required|string',
        ];
    }

    public function referPatient(): void
    {
        $doctor = auth()->user()->doctor;


        if ($this->has('referral')) {
            $referral = $this->file('referral');
            $this->uploadReferralDocument($referral, $doctor->practice_number);
        }

        Referral::create([
            'patient_id' => $this->patient,
            'doctor_id' => $this->refer_to,
            'appointment_id' => $this->appointment,
            'referred_by' => $this->doctor,
            'referred_date' => Carbon::now(),
            'referral_reason' => $this->referral_reason,
        ]);

        $this->updateAppointment($this->appointment);
    }

    private function updateAppointment(int $appointmentId): void
    {
        $appointment =Appointment::find($appointmentId);
        $appointment->status = Appointment::REFERRED_STATUS;
        $appointment->save();
    }

    private function uploadReferralDocument($referral, $practice_number): void
    {

        $fileService = new AppointmentFileService();

        $data ['document_type_id'] = $this->document;
        $data ['appointment_id'] = $this->appointment;

        $result = $fileService->storeFile($referral, AppointmentFileService::REFERRALS_TYPE, $practice_number);
        $data = array_merge($data, $result);

        Document::create($data);

    }
}
