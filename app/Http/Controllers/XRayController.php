<?php

namespace App\Http\Controllers;

use App\Http\Requests\XrayCreateRequest;
use App\Models\Appointment;
use App\Models\DocumentType;
use Illuminate\Http\Request;

class XRayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Appointment $appointment
     * @return \Illuminate\Http\Response
     */
    public function create(Appointment $appointment)
    {
        $document_type = DocumentType::where('name', '=', 'X-Rays')->get();

        return view('doctor.xray.create', compact('appointment', 'document_type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(XrayCreateRequest $request)
    {
        $request->uploadXray();

        session()->flash('success', 'Patient xrays successfully uploaded');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param Appointment $appointment
     * @return void
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
