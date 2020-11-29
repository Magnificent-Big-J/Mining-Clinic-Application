<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Province
 * @package App
 * @property string $name
 * @property Address $addresses
 */
class Province extends Model
{
    protected $fillable = ['province_name'];
    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }
}
