<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Claim
 * @package App\Models
 * @property int $id
 * @property float $claim_amount
 * @property float $paid_by_medical_aid
 * @property float $paid_by_patient
 * @property int $payment_id
 * @property int $status
 * @property date $claim_date
 * @property date $claim_paid_date
 */

class Claim extends Model
{
    protected $fillable = [
        'claim_amount', 'paid_by_medical_aid', 'paid_by_patient',
        'status', 'claim_date', 'claim_paid_date'
    ];

    const PENDING_STATUS = 1;
    const PARTIAL_SETTLED = 2;
    const PAID_STATUS = 3;
    const NO_FUND_STATUS = 4;

    public static $texts = [
        self::PENDING_STATUS => 'Pending',
        self::PAID_STATUS => 'Paid',
        self::PARTIAL_SETTLED => 'Partial Settled',
        self::NO_FUND_STATUS => 'No funds'
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

}
