<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * Class DoctorProduct
 * @package App\Models
 * @property int $id
 * @property float $price
 * @property int $threshold
 * @property int $quantity
 * @property int $doctor_id
 * @property int $product_id
 * @property Product $product
 * @property Doctor $doctor
 * @property ProductStock[]|Collection $productStocks
 * @property Sales[]|Collection $sales
 * @property Prescription[]|Collection $prescriptions
 */
class DoctorProduct extends Model
{
    protected $fillable = ['price', 'doctor_id', 'threshold', 'product_id','quantity'];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
    public function productStocks(): HasMany
    {
        return $this->hasMany(ProductStock::class);
    }
    public function sales()
    {
        return $this->hasMany(Sales::class);
    }
    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }
}
