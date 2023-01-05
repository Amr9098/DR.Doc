<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SeedRolePermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $superAdmin= 'superAdmin';
        $systemAdmin= 'systemAdmin';
        $doctor= 'doctor';
        $Assistant= 'assistant';
        $patient= 'patient';


        Permission::create(['name' => $superAdmin]);
        Permission::create(['name' => $systemAdmin]);
        Permission::create(['name' => $doctor]);
        Permission::create(['name' => $Assistant]);
        Permission::create(['name' => $patient]);





        $role = Role::create(['name' => "Super Admin"]);
        $role->givePermissionTo([$superAdmin]);


        $role = Role::create(['name' => "System Admin"])
        ->givePermissionTo([$systemAdmin]);

        $role = Role::create(['name' => "Doctor"])
        ->givePermissionTo([$doctor]);
        $role = Role::create(['name' => "Assistant"])
        ->givePermissionTo([$Assistant]);
        $role = Role::create(['name' => "patient"])
        ->givePermissionTo([$patient]);
    }
}
