<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Consultation
 * @package App\Models
 * @property int $id
 * @property int $consultation_category_id
 * @property string $name
 */

class Consultation extends Model
{
    protected $fillable = [
        'name', 'consultation_category_id'
    ];
}
