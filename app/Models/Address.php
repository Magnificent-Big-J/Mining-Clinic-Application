<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Address
 * @package App
 * @property string $address_1
 * @property string $address_2
 * @property int $postal_code
 * @property int $address_type_id
 * @property int $patient_id
 * @property int $province_id
 */
class Address extends Model
{
    protected $fillable = [
        'address_1', 'address_2', 'postal_code', 'address_type_id', 'patient_id', 'province_id'
    ];
}
