<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
