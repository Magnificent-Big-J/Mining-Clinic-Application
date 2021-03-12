<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MedicalAidCreateRequest;
use App\Http\Requests\MedicalAidUpdateRequest;
use App\Models\MedicalAid;
use App\Models\MedicalRecord;
use App\Models\Patient;
use Illuminate\Http\Request;

class MedicalAidController extends Controller
{
    public function store(MedicalAidCreateRequest $request): array
    {
        $request->createMedicalAidRecord();
        $patient = Patient::find($request->patient);
        $patient->has_medical_aid = 1;
        $patient->save();

        return [
          'success' => 'Patient medical aid information successfully created.',
          'url'=> route('admin.patients.index')
        ];
    }
    public function update(MedicalAidUpdateRequest $request, MedicalAid $medicalAid): array
    {
        $request->updateMedicalAid($medicalAid);
        return [
            'success' => 'Patient medical aid information successfully updated.',
            'url'=> route('admin.patients.index')
        ];
    }
    public function getMedicalAid(MedicalAid $medicalAid): MedicalAid
    {
        return $medicalAid;
    }
    public function show(MedicalRecord $medicalRecord)
    {
        return view('doctor.mypatients.partials.iframe', compact('medicalRecord'));
    }
}
