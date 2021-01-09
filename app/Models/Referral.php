<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Referral
 * @package App\Models
 * @property int $id
 * @property int $patient_id
 * @property int $doctor_id
 * @property int $appointment_id
 * @property date $referred_date
 * @property string $referral_reason
 */
class Referral extends Model
{
    protected $fillable = ['patient_id', 'doctor_id', 'appointment_id', 'referred_date', 'referral_reason'];
}
