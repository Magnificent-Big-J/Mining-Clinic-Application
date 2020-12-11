<?php

namespace App\Http\Requests;

use App\Models\ConsultationCategory;
use Illuminate\Foundation\Http\FormRequest;

class ConsultationCategoryRequest extends FormRequest
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
            'name'=> 'required|string|unique:consultation_categories'
        ];
    }
    public function createCategory()
    {
        ConsultationCategory::create([
           'name' => $this->name
        ]);
    }
}
