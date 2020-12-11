<?php

namespace App\Http\Controllers;

use App\ConsultationCategory;
use App\Http\Requests\ConsultationCategoryRequest;
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
        //
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
        //
    }
}
