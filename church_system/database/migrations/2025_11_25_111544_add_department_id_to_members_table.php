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
            // Add the department_id foreign key column
            // It is nullable because a member might not be assigned to a department immediately.
            $table->foreignId('department_id')
                  ->nullable()
                  ->after('tenant_id') // Position it logically after tenant_id
                  ->constrained('departments') // Constrains it to the 'id' column of the 'departments' table
                  ->onDelete('set null'); // If a department is deleted, set the member's department_id to NULL
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            // Drop the foreign key constraint first
            $table->dropConstrainedForeignId('department_id');
            
            // Then drop the column
            $table->dropColumn('department_id');
        });
    }
};
