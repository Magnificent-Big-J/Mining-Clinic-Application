<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AddressType
 * @package App\Models
 * @property int $id
 * @property string $name
 * @property Address $addresses
 */
class AddressType extends Model
{
    protected $fillable = ['name'];

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
}
