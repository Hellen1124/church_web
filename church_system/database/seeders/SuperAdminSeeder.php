<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            // ✅ Forget cached permissions to ensure fresh data
            app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

            // ✅ Ensure the "super-admin" role exists
            $role = Role::firstOrCreate(
                ['name' => 'super-admin', 'guard_name' => 'web'],
                ['title' => 'Super Administrator', 'description' => 'System-wide administrative access']
            );

            // ✅ Grant *all* permissions to super-admin
            $permissions = Permission::pluck('name')->toArray();
            $role->syncPermissions($permissions);

            // ✅ Create the global system admin user
            $admin = User::firstOrCreate(
                ['email' => 'superadmin@churchapp.com'],
                [
                    'tenant_id'  => null,
                    'first_name' => 'System',
                    'last_name'  => 'Administrator',
                    'phone'      => '+254704248752',
                    'password'   => Hash::make('Password123'),
                    'otp_token'  => Str::random(6),
                ]
            );

            // ✅ Assign the role to the super admin
           $admin->assignRole('super-admin');

            // ✅ Clear permission cache again
            app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

            $this->command->info('✅ Super Admin created and granted all permissions!');
            $this->command->warn('Email: superadmin@churchapp.com');
            $this->command->warn('Password: Password123');
        });
    }
}
