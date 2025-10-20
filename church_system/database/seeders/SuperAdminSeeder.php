<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
            // ✅ Ensure the role already exists
            $role = Role::where('name', 'super-admin')
            ->where('guard_name', 'web')
            ->firstOrFail();


            // 🧑🏽‍💼 Create the global system admin (you)
            $admin = User::firstOrCreate(
                ['email' => 'superadmin@churchapp.com'],
                [
                    'tenant_id'  => null, // Global user (system-wide)
                    'first_name' => 'System',
                    'last_name'  => 'Administrator',
                    'phone'      => '+254704248752', // should have started with 0
                    'password'   => Hash::make('Password123'), // 
                    'otp_token'  => Str::random(6), // Optional temporary OTP or seed placeholder
                ]
            );

            // 🪄 Assign role to user
            $admin->assignRole($role);

            $this->command->info('✅ Super Admin created and assigned the "super-admin" role successfully!');
            $this->command->warn('Email: superadmin@churchapp.com');
            $this->command->warn('Password: password');
        });
    }
}
