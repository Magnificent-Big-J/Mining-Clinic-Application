<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ProductStock
 * @package App\Models
 * @property int $id
 * @property int $quantity
 * @property dateTime $stock_date
 * @property int $clinic_product_id
 * @property DoctorProduct $doctorProduct
 */
class ProductStock extends Model
{
    use SoftDeletes;
    protected $fillable = ['quantity', 'stock_date', 'clinic_product_id'];

    public function clinicProduct(): BelongsTo
    {
        return $this->belongsTo(ClinicProduct::class);
    }

}
