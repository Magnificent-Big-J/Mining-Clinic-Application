<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    public function screeningQuestionnaire(): HasMany
    {
        return $this->hasMany(ScreeningQuestionnaire::class);
    }

}
