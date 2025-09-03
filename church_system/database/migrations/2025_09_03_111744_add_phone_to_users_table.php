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
            $table->dropColumn('name');
            $table->unsignedBigInteger('tenant_id')->unique()->after('id');
            $table->string('first_name')->after('tenant_id');
            $table->string('last_name')->after('first_name');
            $table->string('phone')->unique()->nullable()->after('email');
        });

    }

    /**
     * Reverse the migrations.
     */
      public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Remove newly added columns
            $table->dropColumn(['tenant_id', 'first_name', 'last_name', 'phone']);

            // Re-add name column
            $table->string('name')->after('id');
        });
    }
};
