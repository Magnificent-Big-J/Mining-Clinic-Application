<?php

namespace App\Http\Requests;

use App\Models\Specialist;
use Illuminate\Foundation\Http\FormRequest;

class SpecialistCreateRequest extends FormRequest
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
            'specialist_name'=>'required|string|unique:specialists,name',
            'specialist_image'=>'required',
        ];
    }

    public function createSpecialist()
    {
        $img = $this->file('specialist_image');
        $img_file = $this->additional_filename() . $img->getClientOriginalName();
        $img->move("specialist/",$img_file);
        $path = 'specialist/' . $img_file;
        Specialist::create([
            'name' => $this->specialist_name,
            'image_path' => $path,
        ]);

    }
    protected function additional_filename(){
        return 'SP-' . time();
    }
}
