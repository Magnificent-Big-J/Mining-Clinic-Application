<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionnaireCreateRequest;
use App\ScreeningQuestionnaire;
use Illuminate\Http\Request;

class ScreeningQuestionnaireController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.questionnaires.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.questionnaires.covid_form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionnaireCreateRequest $request)
    {
        $request->createQuestionnaires();
        session()->flash('success', 'Questionnaire Successfully created');
        return redirect()->route('admin.question.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ScreeningQuestionnaire  $screeningQuestionnaire
     * @return \Illuminate\Http\Response
     */
    public function show(ScreeningQuestionnaire $screeningQuestionnaire)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ScreeningQuestionnaire  $screeningQuestionnaire
     * @return \Illuminate\Http\Response
     */
    public function edit(ScreeningQuestionnaire $screeningQuestionnaire)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ScreeningQuestionnaire  $screeningQuestionnaire
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ScreeningQuestionnaire $screeningQuestionnaire)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ScreeningQuestionnaire  $screeningQuestionnaire
     * @return \Illuminate\Http\Response
     */
    public function destroy(ScreeningQuestionnaire $screeningQuestionnaire)
    {
        //
    }
    public function medical()
    {
        return view('admin.questionnaires.medical_form');
    }
}
