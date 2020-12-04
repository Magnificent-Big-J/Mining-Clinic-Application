<?php

namespace App\Http\Requests;

use App\Models\ScreeningQuestionnaire;
use Illuminate\Foundation\Http\FormRequest;

class QuestionnaireCreateRequest extends FormRequest
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
            'question_name' => 'required|string|unique:screening_questionnaires,name'
        ];
    }
    public function createQuestionnaires()
    {
        $path = null;
        if ($this->has('question_image')) {
            $img = $this->file('question_image');
            $img_file =  $img->getClientOriginalName();
            $img->move("questions/",$img_file);
            $path = 'questions/' . $img_file;
        }
        ScreeningQuestionnaire::create([
            'name'=> $this->question_name,
            'image_path'=> $path,
            'screening_type_id'=> $this->question_type
        ]);
    }
}
