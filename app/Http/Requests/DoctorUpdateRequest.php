<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DoctorUpdateRequest extends FormRequest
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
            'entity_name' => 'required|string|unique:doctors,entity_name,' . $this->doctor->id,
            'entity_status' => 'required|string',
            'entity_email' => 'required|string',
            'practice_number' => 'required|string',
            'vat_number' => 'required',
            'address' => 'required|string',
            'stock_scheme' => 'required|string',
            'reg_number' => 'required|string',
            'specialist_name' => 'required',
        ];
    }
    public function updateDoctor($doctor)
    {
        $doctor->specialists()->detach([$this->specialist_name]);
        $doctor->entity_name = $this->entity_name;
        $doctor->entity_status = $this->entity_status;
        $doctor->email = $this->entity_email;
        $doctor->address = $this->address;
        $doctor->stock_scheme = $this->reg_number;
        $doctor->practice_number = $this->practice_number;
        $doctor->reg_number = $this->reg_number;
        $doctor->fax_number = $this->fax_number;
        $doctor->specialists()->attach([$this->specialist_name]);
        $doctor->save();
    }
}
