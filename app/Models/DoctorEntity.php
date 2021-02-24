<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class DoctorEntity
 * @package App\Models
 * @property int $id
 * @property string $entity_name
 * @property string $entity_status
 * @property string $complex
 * @property string $suburb
 * @property string $city
 * @property int $code
 * @property int $doctor_id
 */
class DoctorEntity extends Model
{
    use SoftDeletes;

    protected $fillable = ['entity_name', 'entity_status', 'reg_number','complex', 'suburb', 'city', 'code', 'doctor_id'];
    const ACTIVE_STATUS = 'active';
    const SUSPENDED_STATUS = 'suspended';
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }
}
