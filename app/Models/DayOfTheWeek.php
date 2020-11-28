<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class DayOfTheWeek
 * @package App\Models
 * @property int $id
 * @property string $name
 */
class DayOfTheWeek extends Model
{
    protected $fillable = ['name'];
}
