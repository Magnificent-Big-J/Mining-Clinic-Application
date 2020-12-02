<?php

use App\Models\Doctor;
use App\Models\Specialist;
use App\User;
use Illuminate\Database\Seeder;

class DoctorDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'first_name' => 'Aubrey',
            'last_name' => 'Hlungwane',
            'title' => 'Dr',
            'email' => 'hlungwaneak@invokesolutions.co.za',
            'password' => bcrypt('p@ssword'),
        ]);

        $user->assignRole(2);

        $specialist = Specialist::create([
            'name' => 'General Practitioner',
            'image_path' =>'specialist/SP-1606811795Orthopedic.png'
        ]);

        $doctor = Doctor::create([
            'entity_name' => $user->title . ' ' . $user->first_name . ' ' . $user->last_name,
            'entity_status' => 'active',
            'reg_number' => '37377373',
            'email' => $user->email,
            'practice_number' => '74747747',
            'vat_number' => '3039387363',
            'tele_number' => '0711420108',
            'fax_number'  => '0123031041',
            'address' => '5th road, midrand, johannesburg, 1682',
            'user_id' => $user->id,
            'stock_scheme' => 'stock_scheme'
        ]);

        $doctor->specialists()->attach($specialist);
    }
}