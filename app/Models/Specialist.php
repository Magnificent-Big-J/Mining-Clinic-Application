<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


/**
 * Class Specialist
 * @package App\Models
 * @property int $id
 * @property string $name
 * @property string $image_path
 */


class Specialist extends Model
{
    protected $fillable = ['name', 'image_path'];

    public function doctors(): BelongsToMany
    {
        return $this->belongsToMany(Doctor::class);
    }
    public function screeningQuestionnaire(): BelongsToMany
    {
        return $this->belongsToMany(ScreeningQuestionnaire::class, 'specialities_screening_questionnaire',  'specialities_id', 'screening_questionnaire_id')->withTimestamps();
    }
}
