<?php

namespace App\Http\Controllers;

use App\Http\Requests\DoctorUpdateRequest;
use App\Models\Doctor;
use App\Http\Requests\DoctorCreateRequest;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.doctors.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.doctors.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DoctorCreateRequest $request)
    {
        $request->createUser();
        session()->flash('success','Doctor record successfully updated.');
        return redirect()->route('admin.doctors.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function show(Doctor $doctor)
    {
        return view('admin.doctors.show', compact('doctor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function edit(Doctor $doctor)
    {
        $specialitiesIds = $doctor->specialists()->pluck('specialists.id')->toArray();;
        return view('admin.doctors.edit', compact('doctor', 'specialitiesIds'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Doctor $doctor)
    {
        $validation_data = [
            'email' => 'required|email|unique:doctors,email,' . $doctor->id,
            'practice_number' => 'required|string|unique:doctors,practice_number,' . $doctor->id,
            'complex' => 'required|regex:/^[a-zA-Z0-9,;\s]+$/',
            'suburb' => 'required|regex:/^[a-zA-Z0-9,;\s]+$/',
            'city' => 'required|regex:/^[a-zA-Z0-9,;\s]+$/',
            'reg_number' => 'required|string|unique:doctors,reg_number,' . $doctor->id,
            'specialist_name' => 'required',
            'postal_code' => 'required|numeric',
        ];
        $updateEntity = false;
        if ($doctor->has_entity === Doctor::HAS_ENTITY_STATE) {
            $data = ['entity_name' => 'required|string|unique:doctor_entities,entity_name,' . $doctor->doctorEntity->id , 'entity_status' => 'required|string'];
            $validation_data = array_merge($validation_data, $data);
            $updateEntity = true;
        }
        $this->validate($request, $validation_data);

        $doctor->specialists()->detach([$request->specialist_name]);
        $doctor->email = $request->email;
        $doctor->complex = $request->complex;
        $doctor->city = $request->city;
        $doctor->suburb = $request->suburb;
        $doctor->code = $request->postal_code;
        $doctor->practice_number = $request->practice_number;
        $doctor->reg_number = $request->reg_number;
        $doctor->fax_number = $request->fax_number;
        $doctor->specialists()->attach([$request->specialist_name]);

        $doctor->save();
        if ($updateEntity) {
            $doctor->doctorEntity->entity_name = $request->entity_name;
            $doctor->doctorEntity->entity_status = $request->entity_status;
            $doctor->doctorEntity->save();
        }
        session()->flash('success','Doctor record successfully updated.');
        return redirect()->route('admin.doctors.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Doctor $doctor)
    {
        if ($doctor->appointments->count()){
            session()->flash('error', 'Doctor cannot be deleted.');
        } else {
            session()->flash('success', 'Doctor successfully deleted.');
        }

        return redirect()->back();
    }
}
