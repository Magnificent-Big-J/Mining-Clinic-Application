<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
    use SoftDeletes;
    protected $fillable = [
        'consultation_fee_id', 'appointment_id', 'payment_id', 'assessment_date'
    ];

    public function consultationFee()
    {
        return $this->belongsTo(ConsultationFee::class);
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
