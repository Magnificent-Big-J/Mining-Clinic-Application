<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClinicUpdateRequest extends FormRequest
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
            'clinic_name' => 'required|regex:/^[a-zA-Z,;\s]+$/|unique:clinics,clinic_name,' . $this->clinic->id,
            'mining_name' => 'required|regex:/^[a-zA-Z,;\s]+$/',
        ];
    }
    public function updateClinic($clinic): void
    {
        $clinic->clinic_name = $this->clinic_name;
        $clinic->mining_name = $this->mining_name;
        $clinic->save();
    }
    public function messages()
    {
        return [
            'clinic_name.regex' => 'Clinic name can contain only letters',
            'Mining_name.regex' => 'Mining name can contain only letters',
        ];
    }
}
