<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class ConsultationFee
 * @package App\Models
 * @property int $id
 * @property float $consultation_fee
 * @property int $consultation_id
 * @property int $doctor_id
 * @property AppointmentAssessment[]|Collection $appointmentAssessment
 */
class ConsultationFee extends Model
{
    protected $fillable = ['consultation_fee', 'consultation_id', 'doctor_id'];

    public function appointmentAssessment()
    {
        return $this->hasMany(AppointmentAssessment::class);
    }
}
