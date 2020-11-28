<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Admin
 * @package App
 * @property int $id
 * @property int $user_id
 * @property User $user
 */
class Admin extends Model
{
    protected $fillable = ['user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function doctors()
    {
        return $this->belongsToMany(Doctor::class);
    }
}
