<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConsultationFeeUpdateRequest extends FormRequest
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
    public function updateConsultationFee($consultationFee)
    {
        $consultationFee->consultation_fee = $this->consultation_fee;
        $consultationFee->consultation_id = $this->consultation;
        $consultationFee->save();
        session()->flash('success', 'Consultation Fee successfully updated.');
    }
}
