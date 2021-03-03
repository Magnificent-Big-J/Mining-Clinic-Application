<?php

namespace App;

use App\Models\Admin;
use App\Models\AdminLogin;
use App\Models\CaseManagement;
use App\Models\CaseSession;
use App\Models\Doctor;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles, SoftDeletes;

    const SUPER_ADMIN_USER = 'Super Admin';
    const DOCTOR_USER = 'Doctor';
    const ADMIN_DOCTOR_USER = 'Admin Doctor';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'title', 'avatar', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function admins(): HasMany
    {
        return $this->hasMany(Admin::class);
    }
    public function caseManagements(): HasMany
    {
        return $this->hasMany(CaseManagement::class);
    }
    public function caseSessions(): HasMany
    {
        return $this->hasMany(CaseSession::class);
    }
    public function doctors(): HasMany
    {
        return $this->hasMany(Doctor::class);
    }

    public function doctor(): HasOne
    {
        return $this->hasOne(Doctor::class);
    }

    public function isSuperAdmin()
    {
        return $this->hasRole(self::SUPER_ADMIN_USER);
    }
    public function isDoctor(): bool
    {
        return $this->hasRole(self::DOCTOR_USER);
    }
    public function isAdminDoctor(): bool
    {
        return $this->hasRole(self::ADMIN_DOCTOR_USER);
    }
    public function getProfileAttribute()
    {
        return (!empty($this->avatar)) ? asset($this->avatar) : asset('avatar/default.jpeg');
    }
    public function getFullNamesAttribute()
    {
        return $this->title . ' ' .  $this->first_name . ' ' . $this->last_name;
    }
    public function medicalRecords(): HasMany
    {
        return $this->hasMany(MedicalRecord::class);
    }
    public function userLoggedInToday(): bool
    {
        $loggedIn = AdminLogin::where('user_id', '=', $this->id)
            ->whereDate('log_on_date', '=', Carbon::now())
            ->first();
        if ($loggedIn) {
            return true;
        } else {
            return  false;
        }
    }
}
