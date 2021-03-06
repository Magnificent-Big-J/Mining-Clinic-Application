<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;


/**
 * Class Patient
 * @package App\Models
 * @property int $id
 * @property string $first_name
 * @property string $second_name
 * @property string $last_name
 * @property string $gender
 * @property date $date_of_birth
 * @property string $identity_number
 * @property bool $is_south_african
 * @property string $work_number
 * @property string $landline
 * @property string $cell_number
 * @property string $email_address
 * @property bool $has_medical_aid
 * @property Address $addresses
 * @property Appointment[]|Collection $appointments
 * @property CaseManagement[]| Collection $caseManagements
 * @property MedicalAid[]|Collection $medicalAid
 * @property Referral[]|Collection $referrals
 * @property MedicalRecord[]|Collection $medicalRecords
 */
class Patient extends Model
{
    use SoftDeletes;
    protected $fillable = ['first_name', 'last_name', 'second_name', 'gender',
        'date_of_birth', 'identity_number', 'is_south_african', 'work_number',
        'landline', 'cell_number', 'has_medical_aid', 'email_address'
        ];

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
    public function caseManagements(): HasMany
    {
        return $this->hasMany(CaseManagement::class);
    }
    public function medicalAid(): HasMany
    {
        return $this->hasMany(MedicalAid::class);
    }
    public function getAgeAttribute()
    {
        return Carbon::parse($this->date_of_birth)->age;
    }
    public function getHasMedicalAttribute()
    {
        return ($this->medicalAid()->exists()) ? $this->medicalAid[0]->medical_aid_number : 'N/A';
    }
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->second_name . ' ' . $this->last_name;
    }
    public function referrals(): HasMany
    {
        return $this->hasMany(Referral::class);
    }

    public function doctors(): BelongsToMany
    {
        return $this->belongsToMany(Doctor::class,'doctor_patient', 'patient_id', 'doctor_id')->withTimestamps();
    }
    public function medicalRecords(): HasMany
    {
        return $this->hasMany(MedicalRecord::class);
    }
    public function physicalAddress()
    {
        return $this->addresses()->where('address_type_id', AddressType::PHYSICAL_TYPE)->first();
    }
    public function postalAddress()
    {
        return $this->addresses()->where('address_type_id', AddressType::POSTAL_TYPE)->first();
    }
}
