<?php

namespace App\Http\Controllers;

use App\Http\Requests\SpecialistCreateRequest;
use App\Models\Specialist;
use Illuminate\Http\Request;

class SpecialistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.specialist.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.specialist.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SpecialistCreateRequest $request)
    {
        $request->createSpecialist();

        session()->flash('success','Specialists successfully updated.');
        return redirect()->route('admin.specialists.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Specialist  $specialist
     * @return \Illuminate\Http\Response
     */
    public function show(Specialist $specialist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Specialist  $specialist
     * @return \Illuminate\Http\Response
     */
    public function edit(Specialist $specialist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Specialist  $specialist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Specialist $specialist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Specialist  $specialist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Specialist $specialist)
    {
        session()->flash('success','Specialists successfully deleted.');
        return redirect()->route('admin.specialists.index');
    }
}
