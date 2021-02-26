<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClinicCreateRequest;
use App\Http\Requests\ClinicUpdateRequest;
use App\Models\Clinic;
use Illuminate\Http\Request;

class ClinicController extends Controller
{
    public function store(ClinicCreateRequest $request): array
    {
        $request->createClinic();
        return [
            'success' => 'Mining Clinic successfully created.',
            'url' => route('admin.clinic.index')
        ];
    }
    public function update(ClinicUpdateRequest $request, Clinic $clinic): array
    {
        $request->updateClinic($clinic);
        return [
            'success' => 'Mining Clinic successfully updated.',
            'url' => route('admin.clinic.index')
        ];
    }
    public function show(Clinic $clinic): Clinic
    {
        return $clinic;
    }
}
