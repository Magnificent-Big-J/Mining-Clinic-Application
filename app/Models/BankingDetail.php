<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BankingDetail
 * @package App\Models
 * @property int $id
 * @property string $bank_name
 * @property string $acc_holder
 * @property int    $acc_number
 * @property int    $branch_code
 * @property int    $doctor_id
 */
class BankingDetail extends Model
{
    protected $fillable = [
        'bank_name', 'acc_number', 'branch_code', 'acc_holder', 'doctor_id'
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
