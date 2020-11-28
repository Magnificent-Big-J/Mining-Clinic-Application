<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Province
 * @package App
 * @property string $name
 */
class Province extends Model
{
    protected $fillable = ['name'];
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
}
