<?php

use App\Models\DayOfTheWeek;
use Illuminate\Database\Seeder;

class DaysOfTheWeekSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $days = array(
            array('days'=>'Monday'),
            array('days'=>'Tuesday'),
            array('days'=>'Wednesday'),
            array('days'=>'Thursday'),
            array('days'=>'Friday'),
            array('days'=>'Saturday'),
            array('days'=>'Sunday'),
        );
        foreach ($days as $day){
            DayOfTheWeek::create($day);
        }
    }
}
