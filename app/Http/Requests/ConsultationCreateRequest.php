<?php

namespace App\Http\Requests;

use App\Models\Consultation;
use Illuminate\Foundation\Http\FormRequest;

class ConsultationCreateRequest extends FormRequest
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
            'name'=> 'required|string|unique:consultations',
            'consultation_type' => 'required'
        ];
    }
    public function createConsultation()
    {
        Consultation::create([
            'name' => $this->name,
            'consultation_category_id' => $this-> consultation_type,
        ]);
    }
}
