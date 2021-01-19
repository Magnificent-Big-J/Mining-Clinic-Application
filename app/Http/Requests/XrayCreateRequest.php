<?php

namespace App\Http\Requests;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Document;
use App\Service\AppointmentFileService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\File;


class XrayCreateRequest extends FormRequest
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
            'xray' => 'required'
        ];
    }
    public function uploadXray(): void
    {
        $doctor = Appointment::find($this->appointment)->doctor;

        $xray = $this->file('xray');
        $fileService = new AppointmentFileService();

        $data ['document_type_id'] = $this->document;
        $data ['appointment_id'] = $this->appointment;

        $result = $fileService->storeFile($xray, AppointmentFileService::XRAY_TYPE, $doctor->practice_number);
        $data = array_merge($data, $result);

        Document::create($data);
    }
}
