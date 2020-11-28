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
 * @property Consultation $consultationFee
 * @property Appointment  $appointment
 */
class AppointmentAssessment extends Model
{
    protected $fillable = [
        'consultation_fee_id', 'appointment_id', 'payment_id', 'assessment_date'
    ];

    public function consultationFee()
    {
        return $this->belongsTo(Consultation::class);
    }
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
