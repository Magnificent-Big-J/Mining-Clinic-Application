<?php

namespace App\Http\Controllers;

use App\Http\Requests\SpecialistCreateRequest;
use App\Http\Requests\SpecialistUpdateRequest;
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

        session()->flash('success','Specialists successfully created.');
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
        return view('admin.specialist.edit', compact('specialist'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Specialist  $specialist
     * @return \Illuminate\Http\Response
     */
    public function update(SpecialistUpdateRequest $request, Specialist $specialist)
    {
        $request->updateSpecialist($specialist);
        session()->flash('success','Specialists successfully updated.');
        return redirect()->route('admin.specialists.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Specialist  $specialist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Specialist $specialist)
    {

        if ($specialist->doctors->count()) {
            session()->flash('error',"Specialists cannot be deleted. One or more doctor assigned to specialities name");
        } else {
            $specialist->doctors()->detach();
            $specialist->screeningQuestionnaire()->detach();
            $specialist->delete();
            session()->flash('success',"Specialists successfully deleted.");
        }


        return redirect()->route('admin.specialists.index');
    }
}
