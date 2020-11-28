<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ScreeningQuestionnaire
 * @package App
 * @property int $id
 * @property string $name
 * @property int  $screening_type_id
 */
class ScreeningQuestionnaire extends Model
{
    protected $fillable = ['name', 'screening_type_id'];
}
