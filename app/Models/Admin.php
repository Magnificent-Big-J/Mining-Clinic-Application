<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function doctors(): BelongsToMany
    {
        return $this->belongsToMany(Doctor::class)->withTimestamps();
    }
}
