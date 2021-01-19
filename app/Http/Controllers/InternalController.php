<?php

namespace App\Http\Controllers;

use App\Http\Requests\XrayCreateRequest;
use App\Models\Appointment;
use App\Models\DocumentType;
use App\Models\Patient;
use App\Service\AppointmentService;
use Illuminate\Http\Request;

class InternalController extends Controller
{
    public function medicalRecords(Patient $patient)
    {
        return view('admin.medicalRecords.show', compact('patient'));
    }
    public function xrayUpload(Appointment $appointment)
    {
        $document_type = DocumentType::where('name', '=', 'X-Rays')->get();
        return view('admin.xray.create', compact('appointment', 'document_type'));
    }
    public function xrayStore(XrayCreateRequest $request)
    {
        $request->uploadXray();

        session()->flash('success', 'Patient xrays successfully uploaded');

        return redirect()->route('admin.historic-appointment.show', $request->appointment);
    }
    public function xrayShow(Appointment $appointment)
    {
        $result = AppointmentService::getDocument($appointment->id, DocumentType::XRAY_TYPE);
        $document_path = $result['document_path'];
        $isPdf = $result['isPdf'];

        return view('admin.xray.show', compact('document_path', 'appointment', 'isPdf'));
    }
}
