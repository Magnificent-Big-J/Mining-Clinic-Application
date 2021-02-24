<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionnaireSpecialitiesUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'question_name' => 'required|string|unique:screening_questionnaires,name,' . $this->screeningQuestionnaire->id
        ];
    }
    public function updateQuestion($screeningQuestionnaire): void
    {
        if ($this->has('question_image')) {
            $img = $this->file('question_image');
            $img_file =  $img->getClientOriginalName();
            $img->move("questions/",$img_file);
            $path = 'questions/' . $img_file;

            $screeningQuestionnaire->image_path = $path;
        }
        $screeningQuestionnaire->specialities()->detach();
        $screeningQuestionnaire->specialities()->attach($this->specialities);

        $screeningQuestionnaire->name = $this->question_name;
        $screeningQuestionnaire->save();
    }
}
