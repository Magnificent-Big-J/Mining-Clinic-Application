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
                return view('admin.patients.partials.medical_aid', compact('patient'));
            })
            ->addColumn('view', function ($patient){
                return view('admin.patients.partials.actions', compact('patient'));
            })
            ->addColumn('edit', function ($patient){
                return view('admin.patients.partials.edit_action', compact('patient'));
            })
            ->addColumn('medical_record', function ($patient){
                return view('admin.patients.partials.medical_record_action', compact('patient'));
            })
            ->addColumn('appointment', function ($patient){
                return view('admin.patients.partials.appointment_action', compact('patient'));
            })
            ->addColumn('book_appointment', function ($patient){
                return view('admin.patients.partials.booking_action', compact('patient'));
            })
            ->addColumn('delete', function ($patient){
                return view('admin.patients.partials.delete_action', compact('patient'));
            })
            ->rawColumns(['age','medical', 'view', 'edit', 'medical_record', 'appointment', 'delete', 'book_appointment'])
            ->make(true);
        //Book Appointment
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
            ->addColumn('view', function ($row){
                return view('admin.doctors.partials.actions', compact('row'));
            })
            ->addColumn('edit', function ($row){
                return view('admin.doctors.partials.edit_action', compact('row'));
            })
            ->addColumn('consultation', function ($row){
                return view('admin.doctors.partials.consultation_action', compact('row'));
            })

            ->rawColumns(['title','first_name', 'last_name','specialist', 'view', 'edit', 'consultation'])
            ->make(true);
    }
    public function appointments($clinic, $doctor)
    {

        $appointments = Appointment::whereDate('appointment_date', '>=', Carbon::now())
            ->where('doctor_id', '=',$doctor)
            ->where('clinic_id', '=', $clinic)
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
            ->addColumn('appointment', function ($row){
                return view('admin.appointments.partials.actions', compact('row'));
            })
            ->addColumn('xray', function ($row){
                return view('admin.appointments.partials.xray_action', compact('row'));
            })
            ->addColumn('delete', function ($row){
                return view('admin.appointments.partials.delete_action', compact('row'));
            })
            ->rawColumns(['title','patient','specialist', 'appointment_status', 'appointment', 'xray', 'delete'])
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
            ->addColumn('action', function ($row){
                return view('admin.questionnaires.partials.actions', compact('row'));
            })
            ->rawColumns(['question_type', 'action'])
            ->make(true);
    }


}
