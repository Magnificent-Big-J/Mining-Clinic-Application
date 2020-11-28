<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AddressType
 * @package App\Models
 * @property int $id
 * @property $name
 */
class AddressType extends Model
{
    protected $fillable = ['name'];
}
