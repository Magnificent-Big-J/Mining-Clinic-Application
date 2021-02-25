<?php

use App\Models\Address;
use App\Models\MedicalAid;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PatientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $patients = [
            [
                'first_name' => 'Godfrey',
                'last_name' => 'Mathiba',
                'second_name' => 'Seth',
                'gender' => 'Male',
                'date_of_birth' => Carbon::now()->subYear(20),
                'identity_number' => '0108245304098',
                'is_south_african' => true,
                'work_number' => '',
                'landline' => '',
                'cell_number' => '0711420108',
                'has_medical_aid' => true,
                'email_address' => 'Godfrey.Mathiba@gmail.com',
            ],
            [
                'first_name' => 'Koketso',
                'last_name' => 'Mabuela',
                'second_name' => '',
                'gender' => 'Male',
                'date_of_birth' => Carbon::now()->subYear(30),
                'identity_number' => '9008245304098',
                'is_south_african' => true,
                'work_number' => '',
                'landline' => '',
                'cell_number' => '0824553100',
                'has_medical_aid' => false,
                'email_address' => 'Koketso.Mabuela@gmail.com',
            ],
            [
                'first_name' => 'Thembi',
                'last_name' => 'Nkuna',
                'second_name' => 'Tintswalo',
                'gender' => 'Female',
                'date_of_birth' => Carbon::now()->subYear(29),
                'identity_number' => '9108245304098',
                'is_south_african' => true,
                'work_number' => '',
                'landline' => '',
                'cell_number' => '0734553100',
                'has_medical_aid' => true,
                'email_address' => 'Thembi.Nkuna@gmail.com',
            ],
            [
                'first_name' => 'Lambert',
                'last_name' => 'Nizeyimana',
                'second_name' => '',
                'gender' => 'Male',
                'date_of_birth' => Carbon::now()->subYear(40),
                'identity_number' => 'B2736464',
                'is_south_african' => false,
                'work_number' => '',
                'landline' => '',
                'cell_number' => '0833031042',
                'has_medical_aid' => true,
                'email_address' => 'Lambert.Nizeyimana@gmail.com',
            ]
        ];

        foreach ($patients as $patient) {
           $patient = Patient::create($patient);
           $patient->doctors()->attach([1]);
        }
        $newSeeds = factory(Patient::class, 100)->create()
            ->each(function ($patient){
                $patient->addresses()->save(factory(Address::class)->make());
            });
        $medicalAids = array(
            array('medical_name' => 'CompCare ','medical_aid_number' => '1616890', 'medical_aid_status' => MedicalAid::ACTIVE_STATUS, 'patient_id'=> 1, 'medical_email_address' => 'correspondence@universal.co.za'),
            array('medical_name' => 'Discovery ','medical_aid_number' => '5876890', 'medical_aid_status' => MedicalAid::ACTIVE_STATUS, 'patient_id'=>3, 'medical_email_address' => 'correspondence@discovery.co.za'),
            array('medical_name' => 'Bonitas ','medical_aid_number' => '3696890', 'medical_aid_status' => MedicalAid::ACTIVE_STATUS, 'patient_id'=> 4, 'medical_email_address' => 'bonitas@universal.co.za'),
        );
        foreach ($medicalAids as $medicalAid) {
            MedicalAid::create($medicalAid);
        }
        $addresses = array(
            array('address_1' => '348 Grey St','address_2' => 'Laudium Centurion','postal_code' => 0037, 'address_type_id' => 1,'patient_id' => 1, 'province_id' => 3),
            array('address_1' => '174 Anthesis St','address_2' => 'Lotus Gardens Pretoria','postal_code' => 0025, 'address_type_id' => 1,'patient_id' => 2, 'province_id' => 3),
            array('address_1' => '240-258 Eridanus St','address_2' => 'Waterkloof Ridge Pretoria','postal_code' => 0350 , 'address_type_id' => 1,'patient_id' => 3, 'province_id' => 3),
            array('address_1' => '33 Toscana Cl','address_2' => 'Lone Hill Sandton','postal_code' => 2062, 'address_type_id' => 1,'patient_id' => 4, 'province_id' => 3),
        );
        foreach ($addresses as $address) {
            Address::create($address);
        }
    }
}
