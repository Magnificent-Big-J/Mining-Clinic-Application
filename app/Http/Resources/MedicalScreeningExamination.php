<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MedicalScreeningExamination extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'question_text' => $this->name,
            'question_id' => $this->id,
            'question_response' => array('Yes', 'No'),
            'question_image' => $this->photo
        ];
    }
}
