<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SpecialistUpdateRequest extends FormRequest
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
            'specialist_name'=>'required|string|unique:specialists,name,' . $this->specialist->id,
        ];
    }
    public function updateSpecialist($specialist): void
    {
       if ($this->has('specialist_image')) {
           $img = $this->file('specialist_image');
           $img_file = $this->additional_filename() . $img->getClientOriginalName();
           $img->move("specialist/",$img_file);
           $path = 'specialist/' . $img_file;

           $specialist->image_path = $path;
       }

       $specialist->name = $this->specialist_name;
       $specialist->save();
    }
    protected function additional_filename(): string
    {
        return 'SP-' . time();
    }
}
