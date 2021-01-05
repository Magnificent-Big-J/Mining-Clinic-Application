<?php

namespace App\Http\Requests;

use App\Models\Doctor;
use App\Models\Document;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\File;


class XrayCreateRequest extends FormRequest
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
            'xray' => 'required'
        ];
    }
    public function uploadXray(): void
    {
        $doctor = auth()->user()->doctor;
        $path = public_path('documents/doctors/xrays/' . $doctor->practice_number);

        if(!File::isDirectory($path)){

            File::makeDirectory($path, 0755, true, true);
        }

        $xray = $this->file('xray');
        $xray_file =  $xray->getClientOriginalName();
        $xray->move($path ,$xray_file);

        Document::create([
            'document_path' => $path,
            'document_type_id' => $this->document,
            'appointment_id' => $this->appointment,
        ]);

    }
}
