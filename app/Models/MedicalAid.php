<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MedicalAid
 * @package App
 * @property int $id
 * @property string $medical_aid_number
 * @property string $medical_name
 * @property string $plan
 * @property int $medical_aid_status
 * @property int $patient_id
 * @property Patient $patient
 */
class MedicalAid extends Model
{
    protected $fillable = ['medical_name','medical_aid_number', 'plan', 'medical_aid_status', 'patient_id'];
    const ACTIVE_STATUS = 1;
    const SUSPENDED = 2;

    public static $texts = [
      self::ACTIVE_STATUS => 'Active',
      self::SUSPENDED => 'Suspended'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
