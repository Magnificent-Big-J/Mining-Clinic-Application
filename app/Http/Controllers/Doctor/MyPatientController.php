<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;

class MyPatientController extends Controller
{
    public function index()
    {
        return view('doctor.mypatients.index');
    }
    public function show(Patient $patient)
    {
        return view('doctor.mypatients.show', compact('patient'));
    }
    public function create(Patient $patient)
    {
        return view('patient.medicalRecords.create', compact('patient'));
    }
}
