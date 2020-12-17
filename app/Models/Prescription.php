<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Prescription
 * @package App
 * @property int $id
 * @property string $days
 * @property int $doctor_product_id
 * @property int $morning_time
 * @property int $quantity
 * @property Appointment $appointment
 * @property DoctorProduct $doctorProduct
 */

class Prescription extends Model
{
    protected $fillable = ['days', 'case_session_id', 'quantity', 'doctor_product_id',
        'morning_time', 'afternoon_time', 'evening_time', 'night_time'];

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }
    public function doctorProduct()
    {
        return $this->belongsTo(DoctorProduct::class);
    }
}
