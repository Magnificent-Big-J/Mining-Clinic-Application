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

        $user = User::create([
            'first_name' => 'Joel',
            'last_name' => 'Mnisi',
            'title' => 'Dr',
            'email' => 'mnisij64@invokesolutions.co.za',
            'password' => bcrypt('p@ssword'),
        ]);

        $user->assignRole(2);

        $specialist = Specialist::create([
            'name' => 'Neurosurgery',
            'image_path' =>'specialist/neurosurgery.jpeg'
        ]);

        $doctor = Doctor::create([
            'entity_name' => $user->title . ' ' . $user->first_name . ' ' . $user->last_name,
            'entity_status' => 'active',
            'reg_number' => '36955285',
            'email' => $user->email,
            'practice_number' => '5522485',
            'vat_number' => '885574125',
            'tele_number' => '0837734919',
            'fax_number'  => '0123031041',
            'address' => '6874 Nokukwane Street Olivenhosboch 0187',
            'user_id' => $user->id,
            'stock_scheme' => 'stock_scheme'
        ]);

        $doctor->specialists()->attach($specialist);

        $user = User::create([
            'first_name' => 'Samuel',
            'last_name' => 'Heaven',
            'title' => 'Dr',
            'email' => 'samuelheaven@yahoo.com',
            'password' => bcrypt('p@ssword'),
        ]);

        $user->assignRole(2);

        $specialist = Specialist::create([
            'name' => 'Pediatrics',
            'image_path' =>'specialist/Pediatrics.jpeg'
        ]);

        $doctor = Doctor::create([
            'entity_name' => $user->title . ' ' . $user->first_name . ' ' . $user->last_name,
            'entity_status' => 'active',
            'reg_number' => '3698565656',
            'email' => $user->email,
            'practice_number' => '25523698',
            'vat_number' => '1425784587',
            'tele_number' => '0734587965',
            'fax_number'  => '0123031041',
            'address' => '301 Madiba Street Pretoria',
            'user_id' => $user->id,
            'stock_scheme' => 'stock_scheme'
        ]);

        $doctor->specialists()->attach($specialist);
    }
}
