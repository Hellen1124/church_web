<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            // Add tenant_id
            if (!Schema::hasColumn('permissions', 'tenant_id')) {
                $table->foreignId('tenant_id')
                    ->nullable()
                    ->after('id')
                    ->constrained()
                    ->nullOnDelete();
            }

            // Add user_id (permission creator)
            if (!Schema::hasColumn('permissions', 'user_id')) {
                $table->foreignId('user_id')
                    ->nullable()
                    ->after('tenant_id')
                    ->constrained()
                    ->nullOnDelete();
            }

            // Add module (to categorize permissions by module)
            if (!Schema::hasColumn('permissions', 'module')) {
                $table->string('module')->nullable()->after('guard_name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permisions', function (Blueprint $table) {
            $table->dropConstrainedForeignIdIfExists('tenant_id');
            $table->dropConstrainedForeignIdIfExists('user_id');
            $table->dropColumnIfExists('module');
        });
    }
};
