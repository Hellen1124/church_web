<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Drop constraints safely before modification
        try {
            DB::statement('ALTER TABLE users DROP FOREIGN KEY users_tenant_id_foreign');
        } catch (\Throwable $e) {}

        try {
            DB::statement('ALTER TABLE users DROP INDEX tenant_id_unique');
        } catch (\Throwable $e) {}

        // ✅ Now modify the column to be nullable
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('tenant_id')->nullable()->change();
        });

        // ✅ Re-add the proper foreign key constraint (set null on delete)
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('tenant_id')
                ->references('id')
                ->on('tenants')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the new foreign key
            try {
                DB::statement('ALTER TABLE users DROP FOREIGN KEY users_tenant_id_foreign');
            } catch (\Throwable $e) {}

            // Revert to NOT NULL + unique (old state)
            $table->unsignedBigInteger('tenant_id')->nullable(false)->change();
            $table->unique('tenant_id', 'tenant_id_unique');
            $table->foreign('tenant_id')
                ->references('id')
                ->on('tenants')
                ->cascadeOnDelete();
        });
    }
};
