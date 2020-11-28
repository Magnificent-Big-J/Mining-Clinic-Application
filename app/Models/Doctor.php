<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Collection;

/**
 * Class Doctor
 * @package App
 * @property int $id
 * @property string $entity_name
 * @property string $entity_status
 * @property string $reg_number
 * @property string $email
 * @property string $practice_number
 * @property int $vat_number
 * @property string $tele_number
 * @property string $fax_number
 * @property string $address
 * @property int $user_id
 * @property int $specialist_id
 * @property string $stock_scheme
 * @property Appointment[]|Collection $appointments
 * @property BankingDetail $banking
 */
class Doctor extends Model
{
    protected $fillable = ['entity_name', 'entity_status', 'reg_number',
        'email', 'practice_number', 'vat_number', 'tele_number', 'fax_number',
        '$address', 'user_id', 'specialist_id', 'stock_scheme'];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
    public function banking()
    {
        return $this->hasOne(BankingDetail::class);
    }
}
