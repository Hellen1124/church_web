<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name'          => 'super-admin',
                'guard_name'    => 'web',
                'title'         => 'System Administrator',
                'description'   => 'Full access to all system features and settings.',
                'tenant_id'     => null, // Global role
                'user_id'       => null, // Created by system
            ],
            [
                'name'          => 'church-admin',
                'guard_name'    => 'web',
                'title'         => 'Church Administrator',
                'description'   => 'Manage all church operations.',
                'tenant_id'     => null,
                'user_id'       => null,
            ],
            // --- NEW ROLE: Church Treasurer (Finance Admin) ---
            [
                'name'          => 'church-treasurer',
                'guard_name'    => 'web',
                'title'         => 'Church Treasurer',
                'description'   => 'Manages church finances, tithes, offerings, and expenses.',
                'tenant_id'     => null,
                'user_id'       => null,
            ],
            // --- NEW ROLE: Church Lead (Member Management) ---
            [
                'name'          => 'church-lead',
                'guard_name'    => 'web',
                'title'         => 'Church Lead',
                'description'   => 'Manages all human resources, member records, and pastoral care.',
                'tenant_id'     => null,
                'user_id'       => null,
            ],
        ];

        foreach ($roles as $roleData) {
            Role::firstOrCreate(
                ['name' => $roleData['name'], 'guard_name' => $roleData['guard_name']],
                $roleData
            );
        }

        $this->command->info('✅ Roles seeded successfully: super-admin, church-admin, church-treasurer, church-lead');
    }
}