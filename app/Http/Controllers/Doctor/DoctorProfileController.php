<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\DoctorProfileUpdateRequest;
use App\User;
use Illuminate\Http\Request;

class DoctorProfileController extends Controller
{
    public function show()
    {
        $doc_specialists = auth()->user()->doctor->specialists()->pluck('specialists.id')->toArray();

        return view('doctor.profile.show', compact('doc_specialists'));
    }
    public function update(DoctorProfileUpdateRequest $request, User $user)
    {
        $request->updateProfile($user);

        return redirect()->route('doctor.profile.settings');
    }
}
