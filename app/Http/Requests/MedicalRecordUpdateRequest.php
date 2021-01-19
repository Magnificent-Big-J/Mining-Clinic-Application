<?php

namespace App\Http\Requests;

use App\Models\MedicalRecord;
use Illuminate\Foundation\Http\FormRequest;

class MedicalRecordUpdateRequest extends FormRequest
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
        ];
    }
    public function updateRecord($medicalRecord)
    {

        if ($this->has('medical_record')) {
            $file = $this->file('medical_record');
            $file_name = $this->additional_filename() . $file->getClientOriginalName();
            $file->move("documents/medicalRecords/",$file_name);
            $path = 'documents/medicalRecords/' . $file_name;
            $medicalRecord->file_name = $file_name;
            $medicalRecord->path = $path;
            $medicalRecord->user_id = auth()->user()->id;
        }

        $medicalRecord->description = $this->description;
        $medicalRecord->record_date = $this->record_date;

        $medicalRecord->save();

    }

    protected function additional_filename(){
        return 'MR-' . time();
    }
}
