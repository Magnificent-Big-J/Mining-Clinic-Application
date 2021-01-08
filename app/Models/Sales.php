<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Sales
 * @package App\Models
 * @property int $id
 * @property int $quantity
 * @property int $appointment_id
 * @property int $prescription_id
 * @property date $sale_date
 * @property Appointment $appointment
 * @property Prescription $prescription
 */

class Sales extends Model
{
    protected $fillable = ['appointment_id', 'prescription_id', 'quantity', 'sale_date'];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
    public function prescription(): HasOne
    {
        return $this->hasOne(Prescription::class);
    }
}
