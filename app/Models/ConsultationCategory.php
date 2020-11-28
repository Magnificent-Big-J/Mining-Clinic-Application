<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ConsultationCategory
 * @package App
 * @property int $id
 * @property string $name
 */

class ConsultationCategory extends Model
{
    protected $fillable = ['name'];
}
