<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'first_name' => 'Invokes',
            'last_name' => 'Solutions',
            'title' => 'Mr',
            'email' => 'info@invokesolutions.co.za',
            'password' => bcrypt('p@ssword'),
        ]);

        $role = Role::findById(1);
        $user->assignRole([$role->id]);
    }
}
