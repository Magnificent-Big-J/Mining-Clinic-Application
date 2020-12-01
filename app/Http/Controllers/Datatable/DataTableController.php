<?php

namespace App\Http\Controllers\Datatable;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Province;
use App\Models\Specialist;
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
}
