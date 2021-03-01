<?php

namespace App\Http\Requests;

use App\Models\Clinic;
use Illuminate\Foundation\Http\FormRequest;

class ClinicCreateRequest extends FormRequest
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
            'clinic_name' => 'required|regex:/^[a-zA-Z,;\s]+$/|unique:clinics',
            'mining_name' => 'required|regex:/^[a-zA-Z,;\s]+$/',
        ];
    }
    public function createClinic()
    {
        Clinic::create([
            'mining_name'=> $this->mining_name,
            'clinic_name'=> $this->clinic_name,
        ]);
    }
    public function messages()
    {
        return [
            'clinic_name.regex' => 'Clinic name can contain only letters',
            'Mining_name.regex' => 'Mining name can contain only letters',
        ];
    }
}
