<?php

namespace App\Http\Controllers;

use App\Models\AppointmentAssessment;
use App\Models\Consultation;
use App\Models\ConsultationCategory;
use App\Http\Requests\ConsultationCategoryRequest;
use App\Models\ConsultationFee;
use Illuminate\Http\Request;

class ConsultationCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.consultation.categories');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ConsultationCategoryRequest $request)
    {
        $request->createCategory();
        session()->flash('success', 'Consultation category successfully created.');
        return redirect()->route('admin.consultation-category.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ConsultationCategory  $consultationCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ConsultationCategory $consultationCategory)
    {
        return view('', compact($consultationCategory));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ConsultationCategory  $consultationCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(ConsultationCategory $consultationCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ConsultationCategory  $consultationCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ConsultationCategory $consultationCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ConsultationCategory  $consultationCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ConsultationCategory $consultationCategory)
    {
        $consultationCategory->delete();
        $consultationIds = Consultation::where('consultation_category_id', $consultationCategory->id)->pluck('id');
        Consultation::where('consultation_category_id', $consultationCategory->id)->update(['deleted_at' => now()]);
        ConsultationFee::whereIn('consultation_id', $consultationIds)->update(['deleted_at' => now()]);
        $consultationFeeIds = ConsultationFee::whereIn('consultation_id', $consultationIds)->pluck('id');
        AppointmentAssessment::whereIn('consultation_fee_id',$consultationFeeIds)->update(['deleted_at' => now()]);
        session()->flash('success', 'Consultation category successfully deleted.');
        return redirect()->route('admin.consultation-category.index');
    }
}
