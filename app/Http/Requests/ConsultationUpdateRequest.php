<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConsultationUpdateRequest extends FormRequest
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
            'name'=> 'required|string|unique:consultations,name,' .$this->consultation->id,
            'consultation_type' => 'required'
        ];
    }
    public function updateConsultation($consultation)
    {
        $consultation->name = $this->name;
        $consultation->consultation_category_id = $this-> consultation_type;
        $consultation->save();
        session()->flash('success', 'Consultation successfully updated.');
    }
}
