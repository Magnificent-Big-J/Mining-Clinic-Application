<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MedicalScreeningExamination;
use App\Models\Doctor;
use App\Models\DoctorProduct;
use App\Models\Screening;
use App\Models\ScreeningQuestionnaire;
use App\Models\ScreeningType;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InternalApiController extends Controller
{
    public function getMedicalQuestions()
    {
        $questions = ScreeningQuestionnaire::where('screening_type_id', '=', ScreeningType::MEDICAL_TYPE)->get();

        return MedicalScreeningExamination::collection($questions);
    }
    public function save(Request $request)
    {
        $questions = explode(',', $request->questions);
        $answers = explode(',', $request->answers);

        foreach ($questions as $key=> $question) {
            Screening::create([
                'appointment_id' => $request->appointment,
                'screening_questionnaire_id' => $question,
                'screening_date' => Carbon::now(),
                'screening_answer' => $answers[$key],
            ]);
        }

        return [
            'message' => 'Thank you, medical examination is successfully created',
            'url' =>route('admin.appointments.index'),
        ];
    }


}
