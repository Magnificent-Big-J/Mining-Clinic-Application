<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Prescription
 * @package App
 * @property int $id
 * @property string $note
 * @property int $case_session_id
 * @property CaseSession $caseSession
 */

class Prescription extends Model
{
    protected $fillable = ['note', 'case_session_id'];

    public function caseSession(): BelongsTo
    {
        return $this->belongsTo(CaseSession::class);
    }
}
