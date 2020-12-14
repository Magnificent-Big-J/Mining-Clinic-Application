<?php

namespace App\Models;

use App\Product;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DoctorProduct
 * @package App\Models
 * @property int $id
 * @property float $price
 * @property int $threshold
 * @property int $doctor_id
 * @property int $product_id
 * @property Product $product
 * @property Doctor $doctor
 */
class DoctorProduct extends Model
{
    protected $fillable = ['price', 'doctor_id', 'threshold', 'product_id'];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
