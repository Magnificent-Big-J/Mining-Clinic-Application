<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Prescription
 * @package App
 * @property int $id
 * @property string $note
 * @property int $case_session_id
 */

class Prescription extends Model
{
    protected $fillable = ['note', 'case_session_id'];
}
