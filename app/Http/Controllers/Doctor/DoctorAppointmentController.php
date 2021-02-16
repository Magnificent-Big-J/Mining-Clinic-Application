<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\PrescriptionUpload;
use App\Models\Appointment;
use App\Models\ConsultationFee;
use App\Models\DocumentType;
use App\Service\AppointmentFileService;
use App\Service\AppointmentService;
use Carbon\Carbon;

class DoctorAppointmentController extends Controller
{
    private $service;

    public function __construct(AppointmentFileService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $appointments = Appointment::whereDate(
            'appointment_date', '>=', Carbon::now())
            ->whereNotIn('status', [Appointment::DECLINED_STATUS, Appointment::DONE_STATUS])
            ->where('doctor_id', '=', auth()->user()->doctor->id)->get();

        return view('doctor.appointments.index', compact('appointments'));
    }
    public function show(Appointment $appointment)
    {
        $result = AppointmentService::getDocument($appointment->id, DocumentType::PRESCRIPTION_TYPE);
        $document_path = $result['document_path'];
        $isPdf = $result['isPdf'];

        $consultationFees = ConsultationFee::where('doctor_id', '=', $appointment->doctor_id)->get();


        return  view('doctor.appointments.show', compact('appointment', 'document_path', 'isPdf', 'consultationFees'));
    }
    public function doctorAppointments()
    {
        return view('doctor.historic-appointment.index');
    }
    public function patientPrescription(Appointment $appointment)
    {
       return view('doctor.prescriptions.show', compact('appointment'));
    }
    public function destroy(Appointment $appointment)
    {
        foreach ($appointment->prescriptions as $prescription) {
            $prescription->delete();
        }
        session()->flash('success', 'Prescription(s) successfully deleted');

        return redirect()->back();
    }
    public function showDocument(Appointment $appointment)
    {
        $result = AppointmentService::getDocument($appointment->id, DocumentType::XRAY_TYPE);
        $document_path = $result['document_path'];
        $isPdf = $result['isPdf'];

        return view('doctor.xray.show', compact('document_path', 'appointment', 'isPdf'));
    }
    public function uploadPrescription(Appointment $appointment)
    {
        $document_type = DocumentType::where('name', '=', 'Prescriptions')->get();
        return  view('doctor.prescriptions.upload', compact('appointment', 'document_type'));
    }
    public function storePrescription(PrescriptionUpload $request)
    {
        $request->uploadPrescription();
        session()->flash('success', 'Patient prescription successfully uploaded');

        return redirect()->route('doctor.appointment.details', $request->appointment);
    }

}
