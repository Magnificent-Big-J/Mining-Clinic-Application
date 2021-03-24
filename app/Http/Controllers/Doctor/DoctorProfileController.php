<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\DoctorProfileUpdateRequest;
use App\Models\Doctor;
use App\Service\Doctor\DoctorService;
use App\User;
use Illuminate\Http\Request;

class DoctorProfileController extends Controller
{
    public function show()
    {
        $doc_specialists = auth()->user()->doctor->specialists()->pluck('specialists.id')->toArray();

        return view('doctor.profile.show', compact('doc_specialists'));
    }
    public function update(Request $request, User $user, DoctorService $service)
    {
        $validation_data = [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:doctors,email,' .$user->doctor->id,
            'practice_number' => 'required|string|unique:doctors,practice_number,' . $user->doctor->id,
            'complex' => 'required|regex:/^[a-zA-Z0-9,;\s]+$/',
            'suburb' => 'required|regex:/^[a-zA-Z0-9,;\s]+$/',
            'city' => 'required|regex:/^[a-zA-Z0-9,;\s]+$/',
            'reg_number' => 'required|string|unique:doctors,reg_number,' . $user->doctor->id,
            'specialist_name' => 'required',
            'postal_code' => 'required|numeric',
            'street' => 'required',
        ];

        if ($user->doctor->has_entity === Doctor::HAS_ENTITY_STATE) {
            $data = ['entity_name' => 'required|string|unique:doctor_entities,entity_name,' . $user->doctor->doctorEntity->id , 'entity_status' => 'required|string'];
            $validation_data = array_merge($validation_data, $data);
        }
        $this->validate($request, $validation_data);
        $service->updateProfile(auth()->user(), $request);
        session()->flash('success','Information Successfully Updated');
        return redirect()->route('doctor.profile.settings');
    }
}
