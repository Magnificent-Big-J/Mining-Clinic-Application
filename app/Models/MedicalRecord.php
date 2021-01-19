<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class MedicalRecord
 * @package App
 * @property int $id
 * @property int $patient_id
 * @property date $record_date
 * @property string $description
 * @property string $path
 * @property string $file_name
 * @property Patient $patient
 * @property int $user_id
 * @property User $user
 */
class MedicalRecord extends Model
{
    protected $fillable = ['patient_id', 'description', 'record_date' ,'path', 'file_name', 'user_id'];

    public function patient(): BelongsTo
    {
        return  $this->belongsTo(Patient::class);
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
