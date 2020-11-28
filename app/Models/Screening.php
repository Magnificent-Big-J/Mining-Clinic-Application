<?php

namespace App\Models;

use App\ScreeningQuestionnaire;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Screening
 * @package App\Models
 * @property int $id
 * @property int $appointment_id
 * @property int $screening_questionnaire_id
 * @property date $screening_date
 * @property string $screening_answer
 * @property ScreeningQuestionnaire $question
 * @property Appointment $appointment
 */


class Screening extends Model
{
    protected $fillable = ['appointment_id', 'screening_questionnaire_id', 'screening_date', 'screening_answer'];

    public function question()
    {
        return $this->belongsTo(ScreeningQuestionnaire::class);
    }
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
