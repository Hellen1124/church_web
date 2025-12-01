<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
            // 🧹 Clear cache
            app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

            // 🗂️ Define system-level modules
            $modules = [
                // SYSTEM-LEVEL
                'users' => ['view', 'create', 'update', 'delete','manage'],
                'roles' => ['view', 'create', 'update', 'delete', 'assign','manage'],
                'permissions' => ['view', 'create', 'update', 'delete', 'assign', 'manage'],
                'tenants' => ['view', 'create', 'update', 'delete'],
                'dashboard' => ['view main', 'view tenant'],
                'profile' => ['view', 'update', 'change password','manage'],
                'settings' => ['view', 'update','manage'],

                // CHURCH-LEVEL (Church Admin)
                'church' => ['view', 'edit', 'manage'],
                'members' => ['view', 'create', 'update', 'delete', 'manage','assign roles'],
                'events' => ['view', 'create', 'update', 'delete', 'manage'],
                'announcements' => ['view', 'create', 'update', 'delete'],
                'reports' => ['view', 'generate'],
                'finance' => ['view', 'record', 'manage'],
                'profiles' => ['view', 'update'],
                'settings' => ['view', 'update'],
                'dashboard' => ['view main', 'view church', 'manage'],
                'departments' => ['view', 'create', 'update', 'delete', 'manage'],

            ];

            foreach ($modules as $module => $actions) {
                foreach ($actions as $action) {
                    Permission::firstOrCreate([
                        'name'       => "{$action} {$module}",
                        'guard_name' => 'web',
                    ], [
                        'module'     => ucfirst($module),
                        'tenant_id'  => null, // Global permissions (system-level)
                        'user_id'    => null,
                    ]);
                }
            }

            $this->command->info('✅ Permissions seeded for users, roles, permissions, and tenants.');
        });
    }
}
