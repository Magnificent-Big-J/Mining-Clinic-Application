<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class CaseManagement
 * @package App\Models
 * @property int $id
 * @property int $patient_id
 * @property int $doctor_id
 * @property string $description
 * @property date $case_date
 * @property int $user_id
 * @property int $status
 * @property Doctor $doctor
 * @property User $user
 * @property Patient $patient
 * @property CaseSession[]| Collection $caseSessions
 */

class CaseManagement extends Model
{
    protected $fillable = [
        'patient_id', 'doctor_id', 'description', 'case_date', 'user_id', 'status'
    ];

    const OPEN_STATUS = 1;
    const CLOSE_STATUS = 2;

    public static $texts = [
      self::OPEN_STATUS => 'Open',
      self::CLOSE_STATUS => 'Close'
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
    public function caseSessions()
    {
        return $this->hasMany(CaseSession::class);
    }
}
