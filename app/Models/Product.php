<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * Class Product
 * @package App\Models
 * @property int $id
 * @property string $product_code
 * @property string $product_name
 * @property string $product_description
 * @property string $product_size
 * @property string $product_unit
 * @property int $product_category_id
 * @property ProductCategory $productCategory
 * @property ClinicProduct[]|Collection $clinicProducts
 */
class Product extends Model
{
    use SoftDeletes;
    protected $fillable = ['product_code', 'product_name', 'product_description', 'product_size', 'product_unit', 'product_category_id'];

    public function productCategory(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class);
    }
    public function clinicProducts(): HasMany
    {
        return $this->hasMany(ClinicProduct::class);
    }
    public function clinic(): BelongsTo
    {
        return $this->belongsTo(Clinic::class);
    }
    public function getNewProductSizeAttribute(): string
    {
        return ($this->product_size ==null ) ? 'N/A': $this->product_size;
    }
    public function getNewProductUnitAttribute(): string
    {
        return ($this->product_unit == null)  ? 'N/A': $this->product_unit;
    }


}
