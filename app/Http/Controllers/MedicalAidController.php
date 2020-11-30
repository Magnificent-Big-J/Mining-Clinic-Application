<?php

namespace App\Http\Controllers;

use App\MedicalAid;
use Illuminate\Http\Request;

class MedicalAidController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.medical.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MedicalAid  $medicalAid
     * @return \Illuminate\Http\Response
     */
    public function show(MedicalAid $medicalAid)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MedicalAid  $medicalAid
     * @return \Illuminate\Http\Response
     */
    public function edit(MedicalAid $medicalAid)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MedicalAid  $medicalAid
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MedicalAid $medicalAid)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MedicalAid  $medicalAid
     * @return \Illuminate\Http\Response
     */
    public function destroy(MedicalAid $medicalAid)
    {
        //
    }
}
