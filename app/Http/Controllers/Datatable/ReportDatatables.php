<?php

namespace App\Http\Controllers\Datatable;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use DataTables;

class ReportDatatables extends Controller
{
    public function historicAppointment()
    {
        $appointments = Appointment::all();

        return DataTables::of($appointments)
            ->addIndexColumn()
            ->addColumn('doctor', function ($row){
                return $row->doctor->user->full_names;
            })
            ->addColumn('patient', function ($row){
                return $row->patient->full_name;
            })
            ->addColumn('specialist', function ($row){
                $row = $row->doctor;
                return view('admin.doctors.partials.specialist', compact('row'));
            })
            ->addColumn('appointment_status', function ($row){
                return $row->status_text;
            })
            ->addColumn('actions', function ($row){
                return view('admin.historic-appointment.partials.actions', compact('row'));
            })
            ->rawColumns(['title','patient','specialist', 'appointment_status', 'actions'])
            ->make(true);
    }
}
