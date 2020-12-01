<?php

use App\Models\AddressType;
use Illuminate\Database\Seeder;

class AddressTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = array(
            array('name'=>'Physical Address'),
            array('name'=>'Postal Address'),
        );

        foreach ($types as $type) {
            AddressType::create($type);
        }
    }
}
