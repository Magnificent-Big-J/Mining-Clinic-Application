<?php

namespace App\Http\Controllers\Datatable;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\ConsultationCategory;
use App\Models\ConsultationFee;
use App\Models\Doctor;
use App\Service\Doctor\ConsultationFeeService;
use App\Service\NumberFormatService;
use DataTables;

class ConsultationDatatableController extends Controller
{
    public function consultationCategories()
    {
        $categories = ConsultationCategory::all();

        return DataTables::of($categories)
            ->addIndexColumn()
            ->addColumn('edit', function ($row){
                return view('admin.consultation.partials.actions', compact('row'));
            })
            ->addColumn('delete', function ($row){
                return view('admin.consultation.partials.delete_category', compact('row'));
            })
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
            ->addColumn('edit', function ($row){
                return view('admin.consultation.partials.consultation_actions', compact('row'));
            })
            ->addColumn('delete', function ($row){
                return view('admin.consultation.partials.delete_consultation', compact('row'));
            })
            ->make(true);
    }
    public function consultationFee(Doctor $doctor, ConsultationFeeService $service)
    {
        $consultationFees = $service->consultationFees($doctor);

        return DataTables::of($consultationFees)
            ->addIndexColumn()
            ->addColumn('category_name', function ($row){
                return $row->consultation->consultationCategory->name;
            })
            ->addColumn('consultation_name', function ($row){
                return $row->consultation->name;
            })
            ->addColumn('consultation_fee_price', function ($row){
                return 'R' . NumberFormatService::format_number($row->consultation_fee);
            })
            ->addColumn('actions', function ($row){
                return view('admin.doctors.partials.consultation_actions', compact('row'));
            })
            ->rawColumns(['category_name','consultation_name', 'consultation_fee_price','actions'])
            ->make(true);
    }
}
