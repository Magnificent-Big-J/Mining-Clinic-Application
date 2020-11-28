<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class Payment
 * @package App
 * @property int $id
 * @property int $payment_type
 * @property float $amount
 * @property date $payment_date
 * @property int $status
 * @property AppointmentAssessment[]|Collection $appointmentAssessment
 * @property Claim[]|Collection $claims
 */
class Payment extends Model
{
    protected $fillable = [
        'payment_type', 'amount', 'payment_date','status'
    ];
    const CASH_PAYEMENT = 1;
    const MEDICAL_AID_PAYMENT = 2;
    const CARD_PAYMENT = 3;

    const PENDING_STATUS = 1;
    const COMPLETE_STATUS = 2;
    const FAILED_STATUS = 3;
    const DECLINED_STATUS = 4;

    public static $paymentTexts = [
            self::CASH_PAYEMENT => 'Cash',
            self::MEDICAL_AID_PAYMENT => 'Medical Aid',
            self::CARD_PAYMENT => 'Card'
        ];
    public static $texts = [
      self::PENDING_STATUS => 'Pending',
      self::COMPLETE_STATUS => 'Complete',
      self::FAILED_STATUS => 'Failed',
      self::DECLINED_STATUS => 'Declined'
    ];
    public function appointmentAssessment()
    {
        return $this->hasMany(AppointmentAssessment::class);
    }
    public function claims()
    {
        return $this->hasMany(Claim::class);
    }
}
