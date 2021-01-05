<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Document
 * @package App\Models
 * @property int $id
 * @property int $document_type_id
 * @property string $document_path
 * @property string $document_name
 * @property int $appointment_id
 * @property DocumentType $documentType
 * @property Appointment $appointment
 */
class Document extends Model
{
    protected $fillable = ['document_type_id', 'document_path', 'appointment_id', 'document_name'];

    public function documentType(): BelongsTo
    {
        return $this->belongsTo(DocumentType::class);
    }
    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }
}
