<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CaseSession
 * @package App\Models
 * @property int $id
 * @property int $case_management_id
 * @property string $notes
 * @property date $case_session_date
 * @property int $status
 * @property int $user_id
 * @property CaseManagement $caseManagement
 * @property User $user
 */
class CaseSession extends Model
{
    protected $fillable = [
        'case_management_id', 'notes', 'case_session_date','status', 'user_id'
    ];

    const NEW_STATUS = 1;
    const FOLLOW_UP = 2;

    public static $texts = [
        self::NEW_STATUS => 'New',
        self::FOLLOW_UP => 'Follow up'
    ];

    public function caseManagement()
    {
        return $this->belongsTo(CaseManagement::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
