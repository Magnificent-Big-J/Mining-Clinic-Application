<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

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
 * @property Sales[]|Collection $sales
 * @property Prescription[]|Collection $prescriptions
 * @property Document[]|Collection $documents
 */
class Appointment extends Model
{
    const PENDING_STATUS = 1;
    const DECLINED_STATUS = 2;
    const ACCEPTED_STATUS = 3;
    const DONE_STATUS = 4;

    public static $texts = [
        self::PENDING_STATUS => 'Pending',
        self::DECLINED_STATUS => 'Declined',
        self::ACCEPTED_STATUS => 'Accepted',
        self::DONE_STATUS => 'Done'
    ];
    protected $fillable = [
        'patient_id', 'doctor_id', 'appointment_date', 'appointment_time', 'status'
    ];

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
    public function appointmentAssessment(): HasMany
    {
        return $this->hasMany(AppointmentAssessment::class);
    }
    public function screening(): HasMany
    {
        return $this->hasMany(Screening::class);
    }
    public function getStatusTextAttribute(): string
    {
        switch ($this->status) {
            case 1:
                return 'Pending';
            case  2:
                return 'Declined';
            case 3:
                return 'Accepted';
            case 4:
                return  'Done';
        }
    }
    public function sales(): HasMany
    {
        return $this->hasMany(Sales::class);
    }
    public function prescriptions(): HasMany
    {
        return $this->hasMany(Prescription::class);
    }
    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }
    public function isPrescription(): bool
    {
        if ($this->documentAvailable(DocumentType::PRESCRIPTION_TYPE)->isEmpty()) {
            return false;
        } else {
            return true;
        }
        return $this->documentAvailable(DocumentType::PRESCRIPTION_TYPE) !== null;
    }
    public function isXray()
    {
        if ($this->documentAvailable(DocumentType::XRAY_TYPE)->isEmpty()) {
            return false;
        } else {
            return true;
        }
        return $this->documentAvailable(DocumentType::XRAY_TYPE)->isEmpty() ? false : true;
    }
    private function documentAvailable(int $type): \Illuminate\Database\Eloquent\Collection
    {
        return $this->documents()->where('document_type_id', '=' , $type)->get();
    }
}
