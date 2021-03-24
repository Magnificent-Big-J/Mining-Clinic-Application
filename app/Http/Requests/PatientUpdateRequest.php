<?php

namespace App\Http\Requests;

use App\Models\AddressType;
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
            'first_name' => 'required|regex:/^[a-zA-Z,;\s]+$/',
            'gender' => 'required|string',
            'last_name' => 'required|string',
            'identity_number' => 'required|string',
            'email_address' => 'required|email|unique:patients,email_address,' . $this->patient->id,
            'is_local' => 'required',
            'second_name' =>'nullable|alpha',
            'cellphone' => 'required',
            'date_of_birth' => 'required',
            'address_1' => 'required|regex:/^[a-zA-Z0-9,;\s]+$/',
            'postal_code' => 'required|numeric',
            'province' => 'required',

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
        $patient->landline = $this->landline;
        $patient->email_address = $this->email_address;
        $patient->save();
        $patient->addresses()->where('address_type_id', AddressType::PHYSICAL_TYPE)->update([
            'address_1' => $this->address_1,
            'address_2' => $this->address_2,
            'postal_code' => $this->postal_code,
            'province_id' => $this->province
        ]);
        if (!empty($this->address_3) && !empty($this->postal_code2)) {
            $patient->addresses()->where('address_type_id', AddressType::POSTAL_TYPE)->updateorCreate([
                'address_1' => $this->address_3,
                'address_2' => $this->address_4,
                'address_type_id' => AddressType::POSTAL_TYPE,
                'province_id' => $this->province2,
                'postal_code' => $this->postal_code2,
            ]);
        }
    }
    public function messages()
    {
        return [
            'address_1.regex' => 'Address can contain letters, numbers or letters with number. e.g 301 Madiba Street',
            'identity_number.regex' => 'Identity number or passport can contain letters, numbers or letters with number.',
            'first_name.regex' => 'First name contains letters only.',
        ];
    }
}
