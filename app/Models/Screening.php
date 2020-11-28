<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Screening
 * @package App\Models
 * @property int $id
 * @property int $appointment_id
 * @property int $screening_questionnaire_id
 * @property date $screening_date
 * @property string $screening_answer
 */


class Screening extends Model
{
    protected $fillable = ['appointment_id', 'screening_questionnaire_id', 'screening_date', 'screening_answer'];
}
