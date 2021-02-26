<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * Class AddressType
 * @package App\Models
 * @property int $id
 * @property string $name
 * @property Address[]|Collection $addresses
 */
class AddressType extends Model
{
    protected $fillable = ['name'];
    const PHYSICAL_TYPE = 1;
    const POSTAL_TYPE = 2;
    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }
}
