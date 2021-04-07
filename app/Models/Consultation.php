<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Consultation
 * @package App\Models
 * @property int $id
 * @property int $consultation_category_id
 * @property string $name
 * @property ConsultationCategory $consultationCategory
 * @property  ConsultationFee $ConsultationFee
 */

class Consultation extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name', 'consultation_category_id'
    ];

    public function consultationCategory(): BelongsTo
    {
        return $this->belongsTo(ConsultationCategory::class);
    }
    public function consultationFee(): HasMany
    {
        return $this->hasMany(ConsultationFee::class);
    }
}
