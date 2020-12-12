<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConsultationCreateRequest;
use App\Http\Requests\ConsultationFeeCreateRequest;
use App\Http\Requests\ConsultationFeeUpdateRequest;
use App\Models\ConsultationFee;
use App\Models\Doctor;
use Illuminate\Http\Request;

class ConsultationFeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Doctor $doctor)
    {
        return view('admin.doctors.consultation_fee', compact('doctor'));
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
    public function store(ConsultationFeeCreateRequest $request)
    {
        $request->createConsultationFee();

        return redirect()->route('admin.consultation.fee.index', $request->doctor);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ConsultationFee  $consultationFee
     * @return \Illuminate\Http\Response
     */
    public function show(ConsultationFee $consultationFee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ConsultationFee  $consultationFee
     * @return \Illuminate\Http\Response
     */
    public function edit(ConsultationFee $consultationFee)
    {
        return view('admin.doctors.edit_consultation_fee', compact('consultationFee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ConsultationFee  $consultationFee
     * @return \Illuminate\Http\Response
     */
    public function update(ConsultationFeeUpdateRequest $request, ConsultationFee $consultationFee)
    {
        $request->updateConsultationFee($consultationFee);
        return redirect()->route('admin.consultation.fee.index', $consultationFee->doctor_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ConsultationFee  $consultationFee
     * @return \Illuminate\Http\Response
     */
    public function destroy(ConsultationFee $consultationFee)
    {
        //
    }
}
