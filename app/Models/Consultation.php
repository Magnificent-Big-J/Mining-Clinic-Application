<?php

namespace App\Models;

use App\ConsultationCategory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Consultation
 * @package App\Models
 * @property int $id
 * @property int $consultation_category_id
 * @property string $name
 * @property ConsultationCategory $category
 */

class Consultation extends Model
{
    protected $fillable = [
        'name', 'consultation_category_id'
    ];

    public function category()
    {
        return $this->belongsTo(ConsultationCategory::class);
    }
}
