<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
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
    use SoftDeletes;
    protected $fillable = ['name'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
