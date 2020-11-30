<?php

namespace App\Http\Controllers\Datatable;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Province;
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
}
