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
        Schema::table('roles', function (Blueprint $table) {
            // Add tenant_id
            if (!Schema::hasColumn('roles', 'tenant_id')) {
                $table->foreignId('tenant_id')
                    ->nullable()
                    ->after('id')
                    ->constrained()
                    ->nullOnDelete();
            }

            // Add user_id (role creator)
            if (!Schema::hasColumn('roles', 'user_id')) {
                $table->foreignId('user_id')
                    ->nullable()
                    ->after('tenant_id')
                    ->constrained()
                    ->nullOnDelete();
            }

            // Add title and description
            if (!Schema::hasColumn('roles', 'title')) {
                $table->string('title')->nullable()->after('user_id');
            }

            if (!Schema::hasColumn('roles', 'description')) {
                $table->text('description')->nullable()->after('title');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropConstrainedForeignIdIfExists('tenant_id');
            $table->dropConstrainedForeignIdIfExists('user_id');
            $table->dropColumn(['title', 'description']);
        });
    }
};
