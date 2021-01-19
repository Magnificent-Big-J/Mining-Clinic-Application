<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;


/**
 * Class Doctor
 * @package App
 * @property int $id
 * @property string $entity_name
 * @property string $entity_status
 * @property string $reg_number
 * @property string $email
 * @property string $practice_number
 * @property int $vat_number
 * @property string $tele_number
 * @property string $fax_number
 * @property string $address
 * @property int $user_id
 * @property int $specialist_id
 * @property string $stock_scheme
 * @property Appointment[]|Collection $appointments
 * @property BankingDetail $banking
 * @property CaseManagement[]| Collection $caseManagements
 * @property User $user
 * @property Referral[]|Collection $referrals
 */
class Doctor extends Model
{
    protected $fillable = ['entity_name', 'entity_status', 'reg_number',
        'email', 'practice_number', 'vat_number', 'tele_number', 'fax_number',
        'address', 'user_id', 'stock_scheme'];

    public function appointments() : HasMany
    {
        return $this->hasMany(Appointment::class);
    }
    public function banking(): HasOne
    {
        return $this->hasOne(BankingDetail::class);
    }
    public function caseManagements(): HasMany
    {
        return $this->hasMany(CaseManagement::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function specialists(): BelongsToMany
    {
        return $this->belongsToMany(Specialist::class);
    }
    public function admins(): BelongsToMany
    {
        return $this->belongsToMany(Admin::class);
    }

    public function getSpecialization(): ?string {
        $result = DB::table('doctor_specialist')
            ->join('specialists', 'doctor_specialist.specialist_id', '=', 'specialists.id')
            ->where('doctor_id', $this->id)
            ->get()->first();

        return $result ? $result->name : null;
    }
    public function referrals(): HasMany
    {
        return $this->hasMany(Referral::class);
    }

    public function patients(): BelongsToMany
    {
        return $this->belongsToMany(Patient::class,'doctor_patient', 'doctor_id', 'patient_id');
    }
}
