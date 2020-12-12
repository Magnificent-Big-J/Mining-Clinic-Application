<?php

namespace App\Http\Controllers\Datatable;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\ConsultationCategory;
use Illuminate\Http\Request;
use DataTables;

class ConsultationDatatableController extends Controller
{
    public function consultationCategories()
    {
        $categories = ConsultationCategory::all();

        return DataTables::of($categories)
            ->addIndexColumn()
            /*->addColumn('actions', function ($row){
                return view('admin.consultation.partials.actions', compact('row'));
            })
            ->rawColumns(['actions'])*/
            ->make(true);
    }
    public function consultation()
    {
        $consultations = Consultation::all();

        return DataTables::of($consultations)
            ->addIndexColumn()
            ->addColumn('category_name', function ($row){
                return $row->consultationCategory->name;
            })
            ->rawColumns(['category_name'])
            ->make(true);
    }
}
