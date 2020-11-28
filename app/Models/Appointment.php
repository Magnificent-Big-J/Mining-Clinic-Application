<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Appointment
 * @package App
 * @property int $id
 * @property int $patient_id
 * @property int $doctor_id
 * @property date $appointment_date
 * @property time $appointment_time
 * @property int $status
 * @property Doctor $doctor
 * @property Patient $patient
 */
class Appointment extends Model
{
    const PENDING_STATUS = 1;
    const DECLINED_STATUS = 2;
    const ACCEPTED_STATUS = 3;

    public static $texts = [
        self::PENDING_STATUS => 'Pending',
        self::DECLINED_STATUS => 'Declined',
        self::ACCEPTED_STATUS => 'Accepted'
    ];
    protected $fillable = [
        'patient_id', 'doctor_id', 'appointment_date', 'appointment_time', 'status'
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
