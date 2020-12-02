<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(DaysOfTheWeekSeeder::class);
        $this->call(AddressTypeSeeder::class);
        $this->call(ProvnceSeeder::class);
        $this->call(RoleAndPermissionsSeeder::class);
        $this->call(UserSeeder::class);

        if (app()->environment('local')) {
            $this->call(DoctorDatabaseSeeder::class);
            $this->call(PatientsTableSeeder::class);
            $this->call(AppointmentTableSeeder::class);
        }
    }
}
