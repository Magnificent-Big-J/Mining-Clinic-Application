<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Schedule
 * @package App\Models
 * @property int $id
 * @property int $day_of_the_week_id
 * @property time $available_time
 * @property int $doctor_id
 */
class Schedule extends Model
{
    protected $fillable = [
        'day_of_the_week_id', 'available_time', 'doctor_id'
    ];
}
