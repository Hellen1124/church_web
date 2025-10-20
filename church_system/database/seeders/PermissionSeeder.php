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
                'users' => ['view', 'create', 'update', 'delete'],
                'roles' => ['view', 'create', 'update', 'delete'],
                'permissions' => ['view', 'create', 'update', 'delete'],
                'tenants' => ['view', 'create', 'update', 'delete'],
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
