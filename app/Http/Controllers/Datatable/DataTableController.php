<?php

namespace App\Http\Controllers\Datatable;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Province;
use App\Models\ScreeningQuestionnaire;
use App\Models\Specialist;
use Carbon\Carbon;
use DataTables;

class DataTableController extends Controller
{
    public function province()
    {
        $provinces = Province::all();

        return DataTables::of($provinces)
            ->addIndexColumn()
            ->make(true);
    }
    public function patients()
    {
        $patients = Patient::all();

        return DataTables::of($patients)
            ->addIndexColumn()
            ->addColumn('age', function ($patient){
                return $patient->age;
            })
            ->addColumn('medical', function ($patient){
                return $patient->has_medical;
            })
            ->addColumn('actions', function ($patient){
                return view('admin.patients.partials.actions', compact('patient'));
            })
            ->rawColumns(['age','medical', 'actions'])
            ->make(true);
    }
    public function specialist()
    {
        $specialist = Specialist::all();

        return DataTables::of($specialist)
            ->addIndexColumn()
            ->addColumn('specialist', function ($row){
                return view('admin.specialist.partials.specialist', compact('row'));
            })
            ->addColumn('actions', function ($row){
                return view('admin.specialist.partials.actions', compact('row'));
            })
            ->rawColumns(['specialist', 'actions'])
            ->make(true);
    }
    public function doctors()
    {
        $doctors = Doctor::all();
        return DataTables::of($doctors)
            ->addIndexColumn()
            ->addColumn('title', function ($row){
                return $row->user->title;
            })
            ->addColumn('first_name', function ($row){
                return $row->user->first_name;
            })
            ->addColumn('last_name', function ($row){
                return $row->user->last_name;
            })
            ->addColumn('specialist', function ($row){
                return view('admin.doctors.partials.specialist', compact('row'));
            })
            ->addColumn('actions', function ($row){
                return view('admin.doctors.partials.actions', compact('row'));
            })
            ->rawColumns(['title','first_name', 'last_name','specialist', 'actions'])
            ->make(true);
    }
    public function appointments()
    {
        $appointments = Appointment::whereDate('appointment_date', '=', Carbon::now())
                ->get();

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
                return view('admin.appointments.partials.actions', compact('row'));
            })
            ->rawColumns(['title','patient','specialist', 'appointment_status', 'actions'])
            ->make(true);
    }
    public function questionnaires()
    {
        $specialist = ScreeningQuestionnaire::all();

        return DataTables::of($specialist)
            ->addIndexColumn()
            ->addColumn('question', function ($row){
                return view('admin.questionnaires.partials.question', compact('row'));
            })
            ->addColumn('question_type', function ($row){
                switch ($row->screening_type_id){
                    case 1:
                        return 'Covid-19';
                    case 2:
                        return 'Medical Examination';

                }
                return ;
            })
            ->rawColumns(['question_type'])
            ->make(true);
    }


}
