<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Collection\Collection;

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

    public function doctors()
    {
        return $this->belongsToMany(Doctor::class);
    }
}
