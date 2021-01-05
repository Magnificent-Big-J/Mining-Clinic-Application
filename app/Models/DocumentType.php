<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * Class DocumentType
 * @package App\Models
 * @property int $id
 * @property string $name
 * @property Document[]|Collection $documents
 */
class DocumentType extends Model
{
    protected $fillable = ['name'];

    const PRESCRIPTION_TYPE = 1;
    const XRAY_TYPE = 2;

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }
}
