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
            ->addColumn('specialities', function ($row){
                return $row->doctor->specialization;
            })
            ->addColumn('patient', function ($row){
                return $row->patient->full_name;
            })
            ->addColumn('appointment_status', function ($row){
                return $row->status_text;
            })
            ->addColumn('appointment_date_new', function ($row){
                return $row->appointment_new_date;
            })
            ->addColumn('actions', function ($row){
                return view('admin.historic-appointment.partials.actions', compact('row'));
            })

            ->make(true);
    }
}
