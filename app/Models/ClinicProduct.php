<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * Class ClinicProduct
 * @package App\Models
 * @property int $id
 * @property float $price
 * @property int $threshold
 * @property int $quantity
 * @property int $doctor_id
 * @property int $product_id
 * @property Product $product
 * @property Clinic $clinic
 * @property ProductStock[]|Collection $productStocks
 * @property Sales[]|Collection $sales
 * @property Prescription[]|Collection $prescriptions
 */


class ClinicProduct extends Model
{
    use SoftDeletes;
    protected $fillable = ['price', 'clinic_id', 'threshold', 'product_id','quantity'];

    public function clinic(): BelongsTo
    {
        return $this->belongsTo(Clinic::class);
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
    public function prescriptions(): HasMany
    {
        return $this->hasMany(Prescription::class);
    }
}
