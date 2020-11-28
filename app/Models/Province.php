<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Province
 * @package App
 * @property string $name
 * @property Address $addresses
 */
class Province extends Model
{
    protected $fillable = ['name'];
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
}
