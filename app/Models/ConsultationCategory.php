<?php

namespace App\Models;

use App\Models\Consultation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ConsultationCategory
 * @package App
 * @property int $id
 * @property string $name
 * @property Consultation $Consultation
 */

class ConsultationCategory extends Model
{
    use SoftDeletes;
    protected $fillable = ['name'];

    public function consultation(): HasMany
    {
        return $this->hasMany(Consultation::class);
    }
}
