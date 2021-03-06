<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Clinic
 * @package App\Models
 * @property int $id
 * @property string $mining_name
 * @property string $clinic_name
 */
class Clinic extends Model
{
    use SoftDeletes;

    protected $fillable = ['mining_name', 'clinic_name'];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}
