<?php

namespace App;

use App\Models\Admin;
use App\Models\CaseManagement;
use App\Models\CaseSession;
use App\Models\Doctor;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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
}
