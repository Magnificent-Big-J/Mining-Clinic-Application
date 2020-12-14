<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Sales
 * @package App\Models
 * @property int $doctor_product_id
 * @property int $quantity
 * @property int $appointment_id
 * @property date $sale_date
 * @property Appointment $appointment
 * @property DoctorProduct $doctorProduct
 */

class Sales extends Model
{
    protected $fillable = ['doctor_product_id','appointment_id', 'quantity', 'sale_date'];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
    public function doctorProduct()
    {
        return $this->belongsTo(DoctorProduct::class);
    }
}
