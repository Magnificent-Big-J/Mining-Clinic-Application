<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
 * @property ScreeningQuestionnaire $screeningQuestionnaire
 */

class Screening extends Model
{
    protected $fillable = ['appointment_id', 'screening_questionnaire_id', 'screening_date', 'screening_answer'];

    public function screeningQuestionnaire(): BelongsTo
    {
        return $this->belongsTo(ScreeningQuestionnaire::class);
    }
    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }
}
