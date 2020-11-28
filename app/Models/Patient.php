<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Patient
 * @package App\Models
 * @property int $id
 * @property string $first_name
 * @property string $second_name
 * @property string $last_name
 * @property string $gender
 * @property date $date_of_birth
 * @property string $identity_number
 * @property bool $is_south_african
 * @property string $work_number
 * @property string $landline
 * @property string $cell_number
 * @property bool $has_medical_aid
 */
class Patient extends Model
{
    protected $fillable = ['first_name', 'last_name', 'second_name', 'gender',
        'date_of_birth', 'identify_number', 'is_south_african', 'work_number',
        'landline', 'cell_number', 'has_medical_aid'
        ];
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
}
