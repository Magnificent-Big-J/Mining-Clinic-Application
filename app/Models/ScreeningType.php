<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class ScreeningType
 * @property int $id
 * @package App\Models
 * @property string $name
 * @property ScreeningQuestionnaire[]|Collection $screeningQuestionnaire
 */

class ScreeningType extends Model
{
    protected $fillable = ['name'];

    public function screeningQuestionnaire()
    {
        return $this->hasMany(ScreeningQuestionnaire::class);
    }

}
