<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientMedicalRecordController extends Controller
{
    public function show(Patient $patient, MedicalRecord $medicalRecord)
    {
        return view('admin.medicalRecords.medical_record', compact('medicalRecord', 'patient'));
    }
}
