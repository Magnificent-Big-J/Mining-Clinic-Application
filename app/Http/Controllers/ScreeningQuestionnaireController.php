<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionnaireCreateRequest;
use App\Http\Requests\QuestionnaireGeneralUpdateRequest;
use App\Http\Requests\QuestionnaireSpecialitiesUpdateRequest;
use App\Models\ScreeningQuestionnaire;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ScreeningQuestionnaireController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('admin.questionnaires.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.questionnaires.covid_form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(QuestionnaireCreateRequest $request)
    {
        $request->createQuestionnaires();
        session()->flash('success', 'Questionnaire Successfully Created');
        return redirect()->route('admin.screeningQuestionnaire.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ScreeningQuestionnaire  $screeningQuestionnaire
     * @return Response
     */
    public function show(ScreeningQuestionnaire $screeningQuestionnaire)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ScreeningQuestionnaire  $screeningQuestionnaire
     * @return Response
     */
    public function edit(ScreeningQuestionnaire $screeningQuestionnaire)
    {

        if ($screeningQuestionnaire->type === ScreeningQuestionnaire::GENERAL_TYPE) {
            return  view('admin.questionnaires.edit.edit', compact('screeningQuestionnaire'));
        } else {
            $qSpecialities = $screeningQuestionnaire->specialities()->pluck('specialists.id')->toArray();

            return  view('admin.questionnaires.edit.editWithSpecialities', compact('screeningQuestionnaire', 'qSpecialities'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ScreeningQuestionnaire  $screeningQuestionnaire
     * @return Response
     */
    public function update(QuestionnaireGeneralUpdateRequest $request, ScreeningQuestionnaire $screeningQuestionnaire)
    {
        $request->updateQuestion($screeningQuestionnaire);
        session()->flash('success', 'Questionnaire Successfully Updated');
        return redirect()->route('admin.screeningQuestionnaire.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ScreeningQuestionnaire $screeningQuestionnaire
     * @return Response
     * @throws \Exception
     */
    public function destroy(ScreeningQuestionnaire $screeningQuestionnaire)
    {

        if ($screeningQuestionnaire->screening->count() > 0) {
           session()->flash('error', 'Question cannot be deleted.');
       } else {
           $screeningQuestionnaire->delete();
           $screeningQuestionnaire->specialities()->detach();
           session()->flash('success', 'Question successfully deleted.');
       }

        return redirect()->back();
    }
    public function medical()
    {
        return view('admin.questionnaires.medical_form');
    }
    public function medicalWithSpecialities()
    {
        return view('admin.questionnaires.medical_form_with_specialities');
    }
    public function updateSpecialities(QuestionnaireSpecialitiesUpdateRequest $request, ScreeningQuestionnaire $screeningQuestionnaire)
    {
        $request->updateQuestion($screeningQuestionnaire);
        session()->flash('success', 'Questionnaire Successfully Updated');
        return redirect()->route('admin.screeningQuestionnaire.index');
    }

}
