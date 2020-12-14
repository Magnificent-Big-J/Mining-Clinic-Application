<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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
 * @property DoctorProduct[]|Collection $doctorProducts
 */
class Product extends Model
{
    protected $fillable = ['product_code', 'product_name', 'product_description', 'product_size', 'product_unit', 'product_category_id'];

    public function productCategory()
    {
        return $this->belongsTo(Product::class);
    }
    public function doctorProducts()
    {
        return $this->hasMany(DoctorProduct::class);
    }
}
