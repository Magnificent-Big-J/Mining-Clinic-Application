<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use phpDocumentor\Reflection\Types\Collection;

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
 * @property bool $has_medical_aid
 * @property Address $addresses
 * @property Appointment[]|Collection $appointments
 * @property CaseManagement[]| Collection $caseManagements
 * @property MedicalAid[]|Collection $medicalAid
 */
class Patient extends Model
{
    protected $fillable = ['first_name', 'last_name', 'second_name', 'gender',
        'date_of_birth', 'identity_number', 'is_south_african', 'work_number',
        'landline', 'cell_number', 'has_medical_aid'
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
        return ($this->medicalAid()->exists()) ? $this->medicalAid->medical_aid_number : 'N/A';
    }
}
