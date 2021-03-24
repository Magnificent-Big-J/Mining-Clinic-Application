<?php

namespace App\Http\Controllers;

use App\Http\Requests\MedicalRecordCreateRequest;
use App\Http\Requests\MedicalRecordUpdateRequest;
use App\Models\MedicalRecord;


class MedicalRecordController extends Controller
{
    public function store(MedicalRecordCreateRequest $request)
    {
        $request->createMedicalRecord();
        session()->flash('success','Patient medical record information successfully created.');
        return redirect()->route('doctor.my.patient.show', $request->patient);
    }

    public function edit(MedicalRecord $medicalRecord)
    {
        return view('patient.medicalRecords.edit', compact('medicalRecord'));
    }

    public function update(MedicalRecordUpdateRequest $request, MedicalRecord $medicalRecord)
    {
        $request->updateRecord($medicalRecord);

        session()->flash('success','Patient medical record information successfully created.');
        return redirect()->route('doctor.my.patient.show', $medicalRecord->patient_id);
    }
    public function show(MedicalRecord $medicalRecord)
    {
        return view('patient.medicalRecords.show', compact('medicalRecord'));
    }
}
