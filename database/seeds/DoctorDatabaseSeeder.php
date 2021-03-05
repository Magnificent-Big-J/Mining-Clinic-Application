<?php

use App\Models\Doctor;
use App\Models\DoctorEntity;
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
            'reg_number' => '37377373',
            'email' => $user->email,
            'practice_number' => '74747747',
            'status' => Doctor::ACTIVE_STATUS,
            'vat_number' => '3039387363',
            'tele_number' => '0711420108',
            'fax_number'  => '0123031041',
            'complex' => 'The Heights Estate',
            'suburb' => 'Midrand 1682',
            'city' => 'Johannesburg',
            'has_entity' => Doctor::HAS_ENTITY_STATE,
            'code' => 1682,
            'user_id' => $user->id,
        ]);

        DoctorEntity::create([
            'entity_name' => $user->title . ' ' . $user->first_name . ' ' . $user->last_name,
            'entity_status' => 'active',
            'complex' => 'The Heights Estate',
            'suburb' => 'Midrand 1682',
            'city' => 'Johannesburg',
            'code' => 1682,
            'doctor_id'=> $doctor->id
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
            'reg_number' => '36955285',
            'email' => $user->email,
            'practice_number' => '5522485',
            'status' => Doctor::ACTIVE_STATUS,
            'vat_number' => '885574125',
            'tele_number' => '0837734919',
            'fax_number'  => '0123031041',
            'complex' => 'Thatchfield Estate',
            'suburb' => 'Centurion',
            'city' => 'Pretoria',
            'has_entity' => Doctor::HAS_ENTITY_STATE,
            'code' => 0152,
            'user_id' => $user->id,
        ]);

        DoctorEntity::create([
            'entity_name' => $user->title . ' ' . $user->first_name . ' ' . $user->last_name,
            'entity_status' => 'active',
            'complex' => 'Thatchfield Estate',
            'suburb' => 'Centurion',
            'city' => 'Pretoria',
            'code' => 0152,
            'doctor_id'=> $doctor->id
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
            'reg_number' => '3698565656',
            'email' => $user->email,
            'practice_number' => '25523698',
            'status' => Doctor::ACTIVE_STATUS,
            'vat_number' => '1425784587',
            'tele_number' => '0734587965',
            'fax_number'  => '0123031041',
            'complex' => '414 Jacqueline Dr',
            'suburb' => 'Garsfontein',
            'city' => 'Pretoria',
            'has_entity' => Doctor::No_ENTITY_STATE,
            'code' => 0042,
            'user_id' => $user->id,
        ]);

        $doctor->specialists()->attach($specialist);
        $users = factory(User::class, 10)->create()
            ->each(function ($user){
                $user->doctors()->save(factory(Doctor::class)->make());
            });

        foreach ($users as $user) {
            $user->assignRole(2);
            $doctor =  Doctor::find($user->doctors[0]->id);
           $doctor->specialists()->attach($specialist);
        }
    }
}
