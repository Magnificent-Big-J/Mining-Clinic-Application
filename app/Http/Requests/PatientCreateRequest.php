<?php

namespace App\Http\Requests;

use App\Models\Address;
use App\Models\AddressType;
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
            'first_name' => 'required|alpha',
            'gender' => 'required|string',
            'last_name' => 'required|alpha',
            'identity_number' => 'required|string|unique:patients',
            'email_address' => 'required|email|unique:patients',
            'is_local' => 'required',
            'cellphone' => 'required|numeric',
            'second_name' =>'nullable|alpha',
            'date_of_birth' => 'required',
            'have_medical' => 'required',
            'address_1' => 'required|regex:/^[a-zA-Z0-9,;\s]+$/',
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
            'email_address' => $this->email_address,
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
            'address_type_id' => AddressType::PHYSICAL_TYPE,
            'patient_id' => $id,
            'province_id' => $this->province
        ]);

        if (!empty($this->address_3) && !empty($this->address_4 && !empty($this->postal_code2) ) ) {

        }
    }
    public function messages()
    {
        return [
            'address_1.regex' => 'Address can contain letters, numbers or letters with number. e.g 301 Madiba Street',
            'identity_number.regex' => 'Identity number or passport can contain letters, numbers or letters with number.',
        ];
    }

}
