<?php

namespace App\Http\Requests;

use App\Models\ConsultationFee;
use App\Service\ConsultationService;
use Illuminate\Foundation\Http\FormRequest;

class ConsultationFeeCreateRequest extends FormRequest
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
            'consultation_fee'=>'required',
            'consultation'=>'required',
        ];
    }
    public function createConsultationFee()
    {
        //check if already have existing record

        if (ConsultationService::recordExists($this->doctor, $this->consultation)) {
            session()->flash('error', 'Consultation Fee already Exists.');
        } else {

            ConsultationFee::create([
               'consultation_fee'=> $this->consultation_fee,
               'consultation_id'=> $this->consultation,
               'doctor_id'=> $this->doctor,
            ]);

            session()->flash('success', 'Consultation Fee successfully created.');
        }

    }
}
