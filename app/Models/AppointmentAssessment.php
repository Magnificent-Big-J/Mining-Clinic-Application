<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AppointmentAssessment
 * @package App
 * @property int $id
 * @property int $consultation_fee_id
 * @property int $appointment_id
 * @property int $payment_id
 * @property date $assessment_date
 */
class AppointmentAssessment extends Model
{
    protected $fillable = [
        'consultation_fee_id', 'appointment_id', 'payment_id', 'assessment_date'
    ];
}
