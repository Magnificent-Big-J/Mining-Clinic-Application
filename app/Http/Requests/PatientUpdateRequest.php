<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class PatientUpdateRequest extends FormRequest
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
            'first_name' => 'required|string',
            'gender' => 'required|string',
            'last_name' => 'required|string',
            'identity_number' => 'required|string|unique:patients,identity_number,' . $this->patient->id,
            'email_address' => 'required|email|unique:patients,email_address,' . $this->patient->id,
            'is_local' => 'required',
            'cellphone' => 'required',
            'date_of_birth' => 'required',
            'have_medical' => 'required',
        ];
    }
    public function updateRecord($patient)
    {
        $patient->first_name = $this->first_name;
        $patient->last_name = $this->last_name;
        $patient->gender = $this->gender;
        $patient->identity_number = $this->identity_number;
        $patient->is_south_african = (int)$this->is_local;
        $patient->work_number = $this->work_number;
        $patient->cell_number = $this->cellphone;
        $patient->second_name = $this->second_name;
        $patient->date_of_birth = Carbon::parse($this->date_of_birth);
        $patient->has_medical_aid = (int)$this->have_medical;
        $patient->landline = $this->landline;
        $patient->email_address = $this->email_address;
        $patient->save();
    }
}
