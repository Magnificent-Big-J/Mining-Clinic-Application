<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Address
 * @package App
 * @property string $address_1
 * @property string $address_2
 * @property int $postal_code
 * @property int $address_type_id
 * @property int $patient_id
 * @property int $province_id
 * @property AddressType $addressType
 */
class Address extends Model
{
    protected $fillable = [
        'address_1', 'address_2', 'postal_code', 'address_type_id', 'patient_id', 'province_id'
    ];

    public function addressType(): BelongsTo
    {
        return $this->belongsTo(AddressType::class);
    }
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }
}
