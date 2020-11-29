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
            array('name'=>'Monday'),
            array('name'=>'Tuesday'),
            array('name'=>'Wednesday'),
            array('name'=>'Thursday'),
            array('name'=>'Friday'),
            array('name'=>'Saturday'),
            array('name'=>'Sunday'),
        );
        foreach ($days as $day){
            DayOfTheWeek::create($day);
        }
    }
}
