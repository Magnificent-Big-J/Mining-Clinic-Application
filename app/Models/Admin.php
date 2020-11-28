<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Admin
 * @package App
 * @property int $id
 * @property int $user_id
 */
class Admin extends Model
{
    protected $fillable = ['user_id'];
}
