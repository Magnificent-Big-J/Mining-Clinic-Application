<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MedicalAidUpdateRequest extends FormRequest
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
            'medical_name' => 'required|regex:/^[a-zA-Z,;\s]+$/',
            'medical_email_address' => 'required|email',
            'medical_aid_number' => 'required|numeric',
        ];
    }

    public function updateMedicalAid($medicalAid)
    {
        $medicalAid->medical_name = $this->medical_name;
        $medicalAid->medical_aid_number= $this->medical_aid_number;
        $medicalAid->plan =  $this->plan;
        $medicalAid->medical_aid_status = $this->status;
        $medicalAid->medical_email_address = $this->medical_email_address;
        $medicalAid->save();
    }
    public function messages()
    {
        return [
            'medical_name.regex' => 'Medical Aid name contains letters only',
        ];
    }
}
