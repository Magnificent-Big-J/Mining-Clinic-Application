<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReferralCreateRequest;
use App\Models\Doctor;
use App\Models\Appointment;
use App\Models\DocumentType;
use App\Models\Referral;
use App\Service\AppointmentService;
use Illuminate\Http\Request;

class ReferralController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('doctor.referrals.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Appointment $appointment
     * @return \Illuminate\Http\Response
     */
    public function create(Appointment $appointment)
    {
        $doctors = Doctor::where('id', '<>', $appointment->doctor->id)->get();
        $document_type = DocumentType::where('name', '=', 'Referrals')->get();
        return view('doctor.referrals.create', compact('appointment', 'doctors', 'document_type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReferralCreateRequest $request)
    {
        $referral = $request->referPatient();
        session()->flash('success', 'Patient successfully referred');

        return redirect()->route('doctor.referrals.show', $referral->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Referral  $referral
     * @return \Illuminate\Http\Response
     */
    public function show(Referral $referral)
    {
        $result = AppointmentService::getDocument($referral->appointment->id, DocumentType::REFERRAL_TYPE);
        $document_path = $result['document_path'];
        $isPdf = $result['isPdf'];
        return view('doctor.referrals.show', compact('referral', 'document_path', 'isPdf'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Referral  $referral
     * @return \Illuminate\Http\Response
     */
    public function edit(Referral $referral)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Referral  $referral
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Referral $referral)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Referral  $referral
     * @return \Illuminate\Http\Response
     */
    public function destroy(Referral $referral)
    {
        //
    }
    public function myReferrals()
    {
        return view('doctor.referrals.my_referrals');
    }
}
