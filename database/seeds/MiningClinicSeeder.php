<?php

use App\Models\Clinic;
use Illuminate\Database\Seeder;

class MiningClinicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clinics = array(
            array('mining_name' => 'Moroaswi Mining', 'clinic_name'=> 'Khumalo Clinic'),
            array('mining_name' => 'Moroaswi Mining', 'clinic_name'=> 'Gebuza Clinic'),
            array('mining_name' => 'Moroaswi Mining', 'clinic_name'=> 'Nkanyane Clinic'),
            array('mining_name' => 'Moroaswi Mining', 'clinic_name'=> 'Gebuza Clinic'),
        );

        foreach ($clinics as $clinic) {
            Clinic::create($clinic);
        }
    }
}
