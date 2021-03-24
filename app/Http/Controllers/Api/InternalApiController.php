<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MedicalScreeningExamination;
use App\Jobs\ClinicStockLevelNotification;
use App\Mail\StockLevelMailNotification;
use App\Models\Clinic;
use App\Models\ClinicProduct;
use App\Models\Doctor;
use App\Models\DoctorProduct;
use App\Models\Screening;
use App\Models\ScreeningQuestionnaire;
use App\Models\ScreeningType;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class InternalApiController extends Controller
{
    public function getMedicalQuestions(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
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
    public function stockLevel(Clinic $clinic, User $user)
    {
        $clinicProducts = ClinicProduct::where('clinic_id', '=', $clinic->id)
            ->where('threshold', '>', DB::raw('quantity'))->get();
        if ($clinicProducts->count()) {
            $success = "Processing stock level, email will be sent after";
            ClinicStockLevelNotification::dispatch($clinicProducts, $user, $clinic);

        } else {
            $success = "All stock is fine";
        }

        return response()->json(['success'=> $success], 200);
    }

}
