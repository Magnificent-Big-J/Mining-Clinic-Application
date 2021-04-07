<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConsultationUpdateRequest;
use App\Models\AppointmentAssessment;
use App\Models\Consultation;
use App\Http\Requests\ConsultationCreateRequest;
use App\Models\ConsultationFee;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.consultation.consultation');
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
    public function store(ConsultationCreateRequest $request)
    {
        $request->createConsultation();
        session()->flash('success', 'Consultation successfully created.');
        return redirect()->route('admin.consultation.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Consultation  $consultation
     * @return \Illuminate\Http\Response
     */
    public function show(Consultation $consultation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Consultation  $consultation
     * @return \Illuminate\Http\Response
     */
    public function edit(Consultation $consultation)
    {
        return view('admin.consultation.edit',compact('consultation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Consultation  $consultation
     * @return \Illuminate\Http\Response
     */
    public function update(ConsultationUpdateRequest $request, Consultation $consultation)
    {
        $request->updateConsultation($consultation);
        return redirect()->route('admin.consultation.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Consultation  $consultation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Consultation $consultation)
    {
        if ($consultation->consultationFee->count()) {
            session()->flash('error', 'Consultation cannot be deleted as it is linked to other active record.');
        } else {
            $consultation->delete();
            ConsultationFee::where('consultation_id', $consultation->id)->update(['deleted_at' => now()]);
            $consultationFeeIds = ConsultationFee::where('consultation_id', $consultation->id)->pluck('id');
            AppointmentAssessment::whereIn('consultation_fee_id',$consultationFeeIds)->update(['deleted_at' => now()]);
            session()->flash('success', 'Consultation successfully deleted.');
        }
        return redirect()->route('admin.consultation.index');
    }
}
