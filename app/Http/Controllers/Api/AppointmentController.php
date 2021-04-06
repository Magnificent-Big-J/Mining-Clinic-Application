<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\AppointmentDeclined;
use App\Jobs\DoctorAcceptedPatientAppointment;
use App\Jobs\PatientAppointmentAccepted;
use App\Jobs\SendInvoiceToMedicalAid;
use App\Jobs\SendInvoiceToPatient;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function update(Request $request, Appointment $appointment)
    {
        $appointment->status = $request->status;
        $appointment->save();
        $shouldReload = true;
        if (intval($appointment->status) === Appointment::ACCEPTED_STATUS) {
            $message = "Appointment has been accepted";
            DoctorAcceptedPatientAppointment::dispatch($appointment);
        } else if (intval($appointment->status) === Appointment::DECLINED_STATUS) {
            $message = "Appointment has been declined";
            AppointmentDeclined::dispatch($appointment);
        } else if (intval($appointment->status) === Appointment::DONE_STATUS) {
            if ($appointment->appointmentAssessment->count() > 0) {
                if ($appointment->patient->has_medical_aid) {
                    SendInvoiceToMedicalAid::dispatch($appointment, $appointment->patient->medicalAid, $appointment->patient->medicalAid[0]->medical_email_address);
                } else {
                    SendInvoiceToPatient::dispatch($appointment);
                }
                $message = "Appointment Marked As Completed.";
            } else {
                $appointment->status = Appointment::ACCEPTED_STATUS;
                $appointment->save();
                $message = "Please select all consultation(s) for this appointment";
                $shouldReload = false;
            }
        }

        return response()->json([
            'success' => $message,
            'shouldReload' => $shouldReload
        ]);
    }
}
