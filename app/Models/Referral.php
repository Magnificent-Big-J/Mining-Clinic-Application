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
 * @property Appointment $appointment
 * @property Patient $patient
 * @property Doctor $doctor
 * @property int $referred_by
 * @property string $referred_to
 * @property string $refer_by_who
 */
class Referral extends Model
{
    protected $fillable = ['patient_id', 'doctor_id', 'appointment_id', 'referred_date', 'referral_reason', 'referred_by'];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
    public function getReferByWhoAttribute()
    {
        $doctor = Doctor::find($this->referred_by);

        return $doctor->user->full_names;
    }
    public function getReferredToAttribute()
    {
        $doctor = Doctor::find($this->doctor_id);

        return $doctor->user->full_names;
    }
}
