<?php

namespace App\Http\Controllers\Datatable;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Appointment;
use DataTables;


class DoctorAppointmentController extends Controller
{
    public function appointments()
    {
        $appointments = Appointment::where('doctor_id', '=', auth()->user()->doctor->id)->get();

        return DataTables::of($appointments)
            ->addIndexColumn()
            ->addColumn('patient_name', function ($row){
                return $row->patient->full_name;
            })
            ->addColumn('appointment_status', function ($row){
                return $row->status_text;
            })
            ->addColumn('actions', function ($row){
                return view('doctor.historic-appointment.partials.actions', compact('row'));
            })
            ->rawColumns(['appointment_status', 'patient_name','actions'])
            ->make(true);
    }
    public function patients()
    {
        $patients = Doctor::find(auth()->user()->doctor->id)->patients;

        return DataTables::of($patients)
            ->addIndexColumn()
            ->addColumn('age', function ($patient){
                return $patient->age;
            })
            ->addColumn('medical', function ($patient){
                return $patient->has_medical;
            })
            ->addColumn('actions', function ($patient){
                return view('doctor.mypatients.partials.actions', compact('patient'));
            })
            ->rawColumns(['age','medical', 'actions'])
            ->make(true);
    }
}
