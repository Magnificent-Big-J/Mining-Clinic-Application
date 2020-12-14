<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class ProductCategory
 * @package App
 * @property int $id
 * @property string $name
 * @property Product[]|Collection $products
 */
class ProductCategory extends Model
{
    protected $fillable = ['name'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
