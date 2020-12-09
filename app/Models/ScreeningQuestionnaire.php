<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
    protected $fillable = ['name', 'screening_type_id', 'image_path'];

    public function screening(): HasMany
    {
        return $this->hasMany(Screening::class);
    }
    public function screeningType(): BelongsTo
    {
        return $this->belongsTo(ScreeningType::class);
    }
    public function getPhotoAttribute()
    {
        return ($this->image_path) ? asset($this->image_path) : asset('questions/default.jpeg');
    }
}
