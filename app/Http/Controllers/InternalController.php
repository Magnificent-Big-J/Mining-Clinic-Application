<?php

namespace App\Http\Controllers;

use App\Http\Requests\XrayCreateRequest;
use App\Mail\StockLevelMailNotification;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\DoctorProduct;
use App\Models\DocumentType;
use App\Models\Patient;
use App\Service\AppointmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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
    public function stockLevel(Doctor $doctor)
    {
        $doctorProducts = DoctorProduct::where('doctor_id', '=', $doctor->id)
            ->where('threshold', '>', DB::raw('quantity'))->get();
        if ($doctorProducts->count()) {
            Mail::to($doctor->email)->send(new StockLevelMailNotification($doctor, $doctorProducts));
            session()->flash('success', 'Email is sent');
        } else {
            session()->flash('success', 'All stock is fine');
        }

        return redirect()->back();
    }
}
