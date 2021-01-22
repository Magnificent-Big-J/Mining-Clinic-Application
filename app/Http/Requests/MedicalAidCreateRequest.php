<?php

namespace App\Http\Requests;

use App\Models\MedicalAid;
use Illuminate\Foundation\Http\FormRequest;

class MedicalAidCreateRequest extends FormRequest
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
            'medical_name' => 'required|alpha',
            'medical_email_address' => 'required|email',
            'medical_aid_number' => 'required|numeric',
        ];
    }
    public function createMedicalAidRecord()
    {
        MedicalAid::create([
            'medical_name' => $this->medical_name,
            'medical_aid_number'=> $this->medical_aid_number,
            'plan'=> $this->plan,
            'medical_aid_status' => $this->status,
            'patient_id' => $this->patient,
            'medical_email_address' => $this->medical_email_address
        ]);
    }
}
