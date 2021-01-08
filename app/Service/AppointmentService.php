<?php


namespace App\Service;


use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\DocumentType;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class AppointmentService
{
    public static function stats()
    {
        return [
            'today_appointments' => Appointment::where('status', '=', Appointment::ACCEPTED_STATUS)->where('appointment_date', '=', Carbon::now())->count() ,
            'upcoming_appointments' => Appointment::where('status', '=', Appointment::ACCEPTED_STATUS)->where('appointment_date', '>', Carbon::now())->count(),
            'doctors_count' => Doctor::count(),
            'patients_count' => Patient::count(),
        ];
    }
    public static function doctorStats()
    {
        return [
            'today_appointments' => Appointment::where('doctor_id', '=', auth()->user()->doctor->id)->where('status', '=', Appointment::ACCEPTED_STATUS)->whereDate('appointment_date', '=', Carbon::now())->count(),
            'upcoming_appointments' => Appointment::where('doctor_id', '=', auth()->user()->doctor->id)->whereDate('appointment_date', '>', Carbon::now())->count(),
            'completed_appointments' => Appointment::where('doctor_id', '=', auth()->user()->doctor->id)->where('status', '=', Appointment::DONE_STATUS)->count(),
        ];
    }
    public static function getDocument(int $appointmentId, int $docType): array
    {
        $appointment = Appointment::find($appointmentId);
        $document_path = null;
        $isPdf = null;
        $document = $appointment->documents()->where('document_type_id', '=', $docType)->get();

        if (!$document->isEmpty()) {
            $document_path = $document[0]->document_path . '/' . $document[0]->document_name;
            $isPdf = strpos($document[0]->document_name, '.pdf');
        }

        return [
            'document_path' => $document_path,
            'isPdf' => $isPdf,
        ];
    }
}
