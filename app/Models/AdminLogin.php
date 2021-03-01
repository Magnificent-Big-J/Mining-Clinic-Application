<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AdminLogin
 * @package App\Models
 * @property int $id
 * @property int $user_id
 * @property int $clinic_id
 * @property date $log_on_date
 */
class AdminLogin extends Model
{
   protected $fillable = ['user_id', 'clinic_id', 'log_on_date'];

   public function user()
   {
       return $this->belongsTo(User::class);
   }
   public function clinic()
   {
       return $this->belongsTo(Clinic::class);
   }
}
