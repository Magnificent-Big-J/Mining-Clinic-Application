<?php

use Illuminate\Database\Seeder;

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
        $this->call(ProvnceSeeder::class);
        $this->call(RoleAndPermissionsSeeder::class);
        $this->call(UserSeeder::class);
    }
}
