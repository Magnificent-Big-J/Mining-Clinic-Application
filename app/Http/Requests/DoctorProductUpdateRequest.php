<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DoctorProductUpdateRequest extends FormRequest
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
            'threshold' => 'required|numeric',
            'price' => 'required',
        ];
    }
    public function updateDoctorProduct($doctorProduct)
    {
        $doctorProduct->price = $this->price;
        $doctorProduct->threshold = $this->threshold;
        $doctorProduct->save();
    }
}
