<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         $this->call([
            RoleSeeder::class,         // Create roles first
            PermissionSeeder::class,   //  Create permissions
            SuperAdminSeeder::class,   //  Create your super admin user
        ]);
    }
}
