<?php

namespace App\Http\Controllers;

use App\Mail\MedicalAidInvoince;
use App\Models\Appointment;
use App\Models\DocumentType;
use App\Models\Sales;
use App\Service\AppointmentService;
use App\Service\DispenseMedicineService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class DispenseMedicineController extends Controller
{
    public function create(Appointment $appointment)
    {
        if ($appointment->prescriptions->count()) {
            return view('admin.dispense.captured', compact('appointment'));
        } else {

            $result = AppointmentService::getDocument($appointment->id, DocumentType::PRESCRIPTION_TYPE);

            $document_path = $result['document_path'];
            $isPdf = $result['isPdf'];

            return view('admin.dispense.uploaded', compact('appointment', 'document_path', 'isPdf'));
        }
    }
    public function dispense(Appointment $appointment)
    {
        $insert_data = [];

        foreach ($appointment->prescriptions as $prescription) {
            $result = DispenseMedicineService::calculate($prescription->clinic_product_id, $prescription->quantity);
            if ($result['shouldCount']) {
                $insert_data[] = [
                    'appointment_id' => $prescription->appointment->id,
                    'prescription_id' => $prescription->id,
                    'quantity' => $result['quantity'],
                    'sale_date' => Carbon::now()
                ];

            }
        }

        if (count($insert_data)) {
            Sales::insert($insert_data);
            if ($appointment->patient->has_medical_aid) {
                $medicalAid = $appointment->patient->medicalAid;
                Mail::to($medicalAid[0]->medical_email_address)->send(new MedicalAidInvoince($appointment, $medicalAid));
            }
        }
        session()->flash('success', 'Medication,  is successfully dispensed');
       return redirect()->route('admin.medicine.dispensed', $appointment->id);
    }

    public function medicineDispensed(Appointment $appointment)
    {
        return view('admin.dispense.dispensed', compact('appointment'));
    }
}
