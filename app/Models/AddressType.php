<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
}
