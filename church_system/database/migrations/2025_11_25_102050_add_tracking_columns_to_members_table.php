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
        Schema::table('members', function (Blueprint $table) {
            // Add created_by: the user who created the record
            $table->foreignId('created_by')->nullable()->constrained('users');
            
            // Add updated_by: the user who last updated the record
            $table->foreignId('updated_by')->nullable()->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            // Drop foreign key constraints first
            $table->dropForeign(['created_by']);
            $table->dropForeign(['updated_by']);
            
            // Then drop the columns
            $table->dropColumn(['created_by', 'updated_by']);
        });
    }
};
