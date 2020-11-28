<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ConsultationFee
 * @package App\Models
 * @property int $id
 * @property float $consultation_fee
 * @property int $consultation_id
 * @property int $doctor_id
 */
class ConsultationFee extends Model
{
    protected $fillable = ['consultation_fee', 'consultation_id', 'doctor_id'];
}
