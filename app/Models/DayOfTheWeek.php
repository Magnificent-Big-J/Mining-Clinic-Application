<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class DayOfTheWeek
 * @package App\Models
 * @property int $id
 * @property string $name
 * @property Schedule[]|Collection $schedules
 */
class DayOfTheWeek extends Model
{
    protected $fillable = ['name'];

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
