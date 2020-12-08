<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Screening;
use App\Models\ScreeningQuestionnaire;
use App\Models\ScreeningType;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AppointmentScreening extends Controller
{
    public function covidScreening(Appointment $appointment, Patient $patient)
    {
        $questions = ScreeningQuestionnaire::where('screening_type_id', '=', ScreeningType::COVID_TYPE)->get();
        $type = 'Covid-19 Screening Questionnaire';
        return view('admin.screening.create', compact('questions', 'appointment', 'patient', 'type'));
    }
    public function store(Request $request)
    {
        $questions = $request->questions;

        foreach ($questions as $key=> $question) {
            $answer = $request->answer_.$key;
            Screening::create([
                'appointment_id' => $request->appointment,
                'screening_questionnaire_id' => $question,
                'screening_date' => Carbon::now(),
                'screening_answer' => $answer,
            ]);
        }

        session()->flash('success', 'Thank you, covid-19 screening is successfully created.');
        return redirect()->route('admin.appointments.index');
    }
}
