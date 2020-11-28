<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Schedule
 * @package App\Models
 * @property int $id
 * @property int $day_of_the_week_id
 * @property time $available_time
 * @property int $doctor_id
 * @property DayOfTheWeek $days
 */
class Schedule extends Model
{
    protected $fillable = [
        'day_of_the_week_id', 'available_time', 'doctor_id'
    ];

    public function days(): BelongsTo
    {
        return $this->belongsTo(DayOfTheWeek::class);
    }
}
