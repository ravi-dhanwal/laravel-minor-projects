<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'view users',
            'manage users',
            'assign roles',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission);
        }

        $admin = Role::findOrCreate('admin');
        $admin->syncPermissions($permissions);

        $manager = Role::findOrCreate('manager');
        $manager->syncPermissions(['view users']);

        Role::findOrCreate('user');

        // Backfill: assign a Spatie role to existing users based on their `role` column
        \App\Models\User::all()->each(function ($user) {
            if (!$user->hasRole($user->role)) {
                $user->assignRole($user->role);
            }
        });
    }
}
