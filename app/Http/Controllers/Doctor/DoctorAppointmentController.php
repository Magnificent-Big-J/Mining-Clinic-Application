<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Service\AppointmentFileService;
use Carbon\Carbon;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use ImagickException;
use Symfony\Component\Finder\Exception\DirectoryNotFoundException;

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
        return  view('doctor.appointments.show', compact('appointment'));
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
        $document_path = $appointment->documents[0]->document_path . '/' . $appointment->documents[0]->document_name;
        $isPdf = strpos($appointment->documents[0]->document_name, '.pdf');

        return view('doctor.xray.show', compact('document_path', 'appointment', 'isPdf'));
    }

}
