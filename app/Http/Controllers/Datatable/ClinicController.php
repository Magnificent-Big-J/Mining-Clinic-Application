<?php

namespace App\Http\Controllers\Datatable;

use App\Http\Controllers\Controller;
use App\Models\Clinic;
use Illuminate\Http\Request;
use DataTables;

class ClinicController extends Controller
{
    public function index()
    {
        $clinics = Clinic::all();

        return DataTables::of($clinics)
            ->addIndexColumn()
            ->addColumn('actions', function ($clinic){
                return view('admin.clinic.partials.actions', compact('clinic'));
            })
            ->rawColumns(['actions'])
            ->make(true);
    }
}
