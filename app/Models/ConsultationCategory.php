<?php

namespace App\Models;

use App\Models\Consultation;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ConsultationCategory
 * @package App
 * @property int $id
 * @property string $name
 * @property Consultation $Consultation
 */

class ConsultationCategory extends Model
{
    protected $fillable = ['name'];

    public function Consultation()
    {
        return $this->hasMany(Consultation::class);
    }
}
