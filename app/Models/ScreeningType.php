<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ScreeningType
 * @property int $id
 * @package App\Models
 * @property string $name
 */

class ScreeningType extends Model
{
    protected $fillable = ['name'];

}
