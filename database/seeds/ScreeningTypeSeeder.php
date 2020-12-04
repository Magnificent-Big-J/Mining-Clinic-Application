<?php

use App\Models\ScreeningType;
use Illuminate\Database\Seeder;

class ScreeningTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = array(
            array('name'=>'Covid-19'),
            array('name'=>'Medical Examination'),
        );

        foreach ($types as $type) {
            ScreeningType::create($type);
        }
    }
}
