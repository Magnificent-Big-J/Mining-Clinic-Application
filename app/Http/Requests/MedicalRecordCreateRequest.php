<?php

namespace App\Http\Requests;

use App\Models\MedicalRecord;
use Illuminate\Foundation\Http\FormRequest;

class MedicalRecordCreateRequest extends FormRequest
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
            'description' => 'required|string',
            'record_date' => 'required',
            'medical_record' => 'required',

        ];
    }

    public function createMedicalRecord()
    {
        $file = $this->file('medical_record');
        $file_name = $this->additional_filename() . $file->getClientOriginalName();
        $file->move("documents/medicalRecords/",$file_name);
        $path = 'documents/medicalRecords/' . $file_name;


        MedicalRecord::create([
            'patient_id' => $this->patient,
            'description' => $this->description,
            'record_date' => $this->record_date,
            'path' => $path,
            'file_name' => $file_name,
            'user_id' => auth()->user()->id,
        ]);

    }

    protected function additional_filename(){
        return 'MR-' . time();
    }
}
