<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = array(
            array('name'=>'Super Admin'),
            array('name'=>'Doctor'),
            array('name'=>'Admin Doctor'),
        );

        foreach ($roles as $role) {
            Role::create($role);
        }
        $suPermissions = array(
            'create-everything',
            'list-everything',
            'edit-everything',
            'delete-everything',
            'update-everything',
            'create-doctor-record',
            'list-doctor-record',
            'edit-doctor-record',
            'delete-doctor-record',
            'update-doctor-record',
        );

        foreach ($suPermissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $permissions = Permission::where('id','<=', 5)->pluck('id','id')->all();
        $role = Role::findById(1);
        $role->syncPermissions($permissions);

        $permissions = Permission::where('id','>', 5)->pluck('id','id')->all();
        $role = Role::findById(2);
        $role->syncPermissions($permissions);

        $role = Role::findById(3);
        $role->syncPermissions($permissions);

    }
}
