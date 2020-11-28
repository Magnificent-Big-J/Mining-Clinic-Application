<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class ScreeningQuestionnaire
 * @package App
 * @property int $id
 * @property string $name
 * @property int  $screening_type_id
 * @property Screening[]|Collection $screening
 * @property ScreeningType $screeningType
 */
class ScreeningQuestionnaire extends Model
{
    protected $fillable = ['name', 'screening_type_id'];

    public function screening()
    {
        return $this->hasMany(Screening::class);
    }
    public function screeningType()
    {
        return $this->belongsTo(ScreeningType::class);
    }
}
