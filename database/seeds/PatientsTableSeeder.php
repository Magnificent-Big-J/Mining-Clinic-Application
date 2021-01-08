<?php

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
                'has_medical_aid' => true
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
                'has_medical_aid' => false
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
                'has_medical_aid' => true
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
                'has_medical_aid' => true
            ]
        ];

        foreach ($patients as $patient) {
            Patient::create($patient);
        }
        $medicalAids = array(
            array('medical_name' => 'CompCare ','medical_aid_number' => '1616890', 'medical_aid_status' => MedicalAid::ACTIVE_STATUS, 'patient_id'=> 1, 'medical_email_address' => 'correspondence@universal.co.za'),
            array('medical_name' => 'Discovery ','medical_aid_number' => '5876890', 'medical_aid_status' => MedicalAid::ACTIVE_STATUS, 'patient_id'=>3, 'medical_email_address' => 'correspondence@discovery.co.za'),
            array('medical_name' => 'Bonitas ','medical_aid_number' => '3696890', 'medical_aid_status' => MedicalAid::ACTIVE_STATUS, 'patient_id'=> 4, 'medical_email_address' => 'bonitas@universal.co.za'),
        );
        foreach ($medicalAids as $medicalAid) {
            MedicalAid::create($medicalAid);
        }
    }
}
