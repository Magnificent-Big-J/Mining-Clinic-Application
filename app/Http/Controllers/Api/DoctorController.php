<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DoctorCreateRequest;
use App\Service\Doctor\DoctorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DoctorController extends Controller
{
    public function store(Request $request, DoctorService $service)
    {

        $validation_data = [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'title' => 'required|string',
            'email' => 'required|email|unique:users',
            'practice_number' => 'required|string|unique:doctors',
            'complex' => 'required|regex:/^[a-zA-Z0-9,;\s]+$/',
            'suburb' => 'required|regex:/^[a-zA-Z0-9,;\s]+$/',
            'city' => 'required|regex:/^[a-zA-Z0-9,;\s]+$/',
            'reg_number' => 'required|string|unique:doctors',
            'specialist_name' => 'required',
            'postal_code' => 'required|numeric',
        ];
        if ($request->has('has_entity') && $request->has_entity == 'on') {
            $data = ['entity_name' => 'required|string|unique:doctor_entities', 'entity_status' => 'required|string'];
            $validation_data = array_merge($validation_data, $data);
        }
        $this->validate($request, $validation_data);

        $service->createUser($request);

        return response()->json([
            'success'  => 'Doctor record successfully',
            'url' => route('admin.doctors.index')
        ]);
    }
}
