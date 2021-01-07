<?php

namespace App\Http\Requests;

use App\Models\Document;
use App\Service\AppointmentFileService;
use Illuminate\Foundation\Http\FormRequest;

class PrescriptionUpload extends FormRequest
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
            'prescription' => 'required'
        ];
    }
    public function uploadPrescription() : void
    {
        $doctor = auth()->user()->doctor;

        $xray = $this->file('prescription');
        $fileService = new AppointmentFileService();

        $data ['document_type_id'] = $this->document;
        $data ['appointment_id'] = $this->appointment;

        $result = $fileService->storeFile($xray, AppointmentFileService::PRESCRIPTION_TYPE, $doctor->practice_number);
        $data = array_merge($data, $result);

        Document::create($data);
    }
}
