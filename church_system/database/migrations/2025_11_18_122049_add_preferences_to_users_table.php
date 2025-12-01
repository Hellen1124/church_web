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
        Schema::table('users', function (Blueprint $table) {
            // Add a JSON column for storing user preferences (theme, notifications, etc.)
            // JSON is the best type for flexible key-value data in MySQL/PostgreSQL.
            $table->json('preferences')->nullable()->after('remember_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('users', function (Blueprint $table) {
            // Remove the column if the migration is rolled back
            $table->dropColumn('preferences');
        });
    }
};
