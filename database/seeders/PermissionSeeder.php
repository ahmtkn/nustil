<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (config('nustil.seed.roles') as $role) {
            Role::create(['name' => $role]);
        }
        $permissions = [];
        foreach (config('nustil.seed.permissions') as $permission) {
            foreach (['.create', '.read', '.update', '.delete'] as $action) {
                $permissions[$permission.$action] = Permission::create(['name' => $permission.$action]);
            }
        }
        $admin = Role::findByName('Yönetici');
        foreach ($permissions as $perm) {
            $admin->givePermissionTo($perm);
        }
    }
}
