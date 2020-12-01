<?php

namespace App\Http\Requests;

use App\Models\Address;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class PatientCreateRequest extends FormRequest
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
            'identity_number' => 'required|string|unique:patients',
            'is_local' => 'required',
            'cellphone' => 'required',
            'second_name' => 'required|string',
            'date_of_birth' => 'required',
            'have_medical' => 'required',
            'address_1' => 'required|string',
            'postal_code' => 'required|numeric',
            'province' => 'required',

        ];
    }

    public function createPatient()
    {
       $patient = Patient::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'gender' => $this->gender,
            'identity_number' => $this->identity_number,
            'is_south_african' => (int)$this->is_local,
            'work_number' => $this->work_number,
            'cell_number' => $this->cellphone,
            'second_name' => $this->second_name,
            'date_of_birth' => Carbon::parse($this->date_of_birth),
            'has_medical_aid' => (int)$this->have_medical,
            'landline' => $this->landline,
        ]);

       $this->createAddress($patient->id);

       return $patient;
    }
    private function createAddress(int $id)
    {

        Address::create([
            'address_1' => $this->address_1,
            'address_2' => $this->address_2,
            'postal_code' => $this->postal_code,
            'address_type_id' => 1,
            'patient_id' => $id,
            'province_id' => $this->province
        ]);

        if (!empty($this->address_3) && !empty($this->address_4 && !empty($this->postal_code2) ) ) {

        }
    }
}
