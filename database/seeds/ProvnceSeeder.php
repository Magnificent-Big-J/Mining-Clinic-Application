<?php

use App\Models\Province;
use Illuminate\Database\Seeder;

class ProvnceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $provinces = array(array('province_name'=>'Eastern Cape'),
            array('province_name'=>'Free State'),
            array('province_name'=>'Gauteng'),
            array('province_name'=>'KwaZulu-Natal'),
            array('province_name'=>'Limpopo'),
            array('province_name'=>'Mpumalanga'),
            array('province_name'=>'North West'),
            array('province_name'=>'Northern Cape'),
            array('province_name'=>'Western Cape'),
        );

        foreach ($provinces as $province) {
            Province::create($province);
        }
    }
}
