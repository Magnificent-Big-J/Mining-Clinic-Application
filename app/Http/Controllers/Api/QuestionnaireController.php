<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ScreeningQuestionnaire;
use App\Models\ScreeningType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuestionnaireController extends Controller
{
    public function questionnaire()
    {
        return view('admin.questionnaires.partials.screeningQuestionnaire');
    }
    public function questionnaireWithSpecialities(int $count)
    {
        return view('admin.questionnaires.partials.screeningWithSpecialities', compact('count'));
    }
    public function storeGeneral(Request $request)
    {
        $rules = array(
            'question_name.*'  => 'required|string|unique:screening_questionnaires,name',
            'question_image.*'  => 'required',
        );
        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json([
                'error'  => $error->errors()->all()
            ]);
        }

        $question_names = $request->question_name;
        for($i = 0, $iMax = count($question_names); $i < $iMax; $i++)
        {
            $img = $request->file('question_image')[$i];
            $img_file =  $img->getClientOriginalName();
            $img->move("questions/",$img_file);
            $path = 'questions/' . $img_file;
            $data = array(
                'name'=> $request->question_name[$i],
                'image_path'=> $path,
                'screening_type_id'=> ScreeningType::MEDICAL_TYPE
            );

            $insert_data[] = $data;
        }
        ScreeningQuestionnaire::insert($insert_data);
        return response()->json([
            'success'  => 'Screening Questionnaire Successfully Added.'
        ]);
    }
    public function storeWithSpecialities(Request $request)
    {
        $rules = array(
            'question_name.*'  => 'required|string|unique:screening_questionnaires,name',
            'question_image.*'  => 'required',
            'specialities.*'  => 'required',
        );
        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json([
                'error'  => $error->errors()->all()
            ]);
        }

        $question_names = $request->question_name;
        for($i = 0, $iMax = count($question_names); $i < $iMax; $i++)
        {
            $img = $request->file('question_image')[$i];
            $img_file =  $img->getClientOriginalName();
            $img->move("questions/",$img_file);
            $path = 'questions/' . $img_file;
           $screening =  ScreeningQuestionnaire::create([
                'name'=> $request->question_name[$i],
                'image_path'=> $path,
                'screening_type_id'=> ScreeningType::MEDICAL_TYPE,
                'type' => ScreeningQuestionnaire::SPECIALITY_TYPE,
                ]
            );
           $screening->specialities()->attach([$request->specialities[$i]]);

        }

        return response()->json([
            'success'  => 'Screening Questionnaire Successfully Added.'
        ]);
    }

}
