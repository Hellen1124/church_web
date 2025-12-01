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
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            
            // Core Tenancy
            $table->foreignId('tenant_id')
                  ->constrained('tenants') // Assuming a 'tenants' table exists
                  ->onDelete('cascade');

            // Department Details
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->string('status', 20)->default('Active'); // e.g., Active, Inactive

            // Relationships (Foreign Keys)
            // The leader is an existing User. If the User is deleted, the leader_id is set to NULL.
            $table->foreignId('leader_id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null');

            // Auditing Columns (From TracksUserActions Trait)
            // If the creating/updating User is deleted, set the column to NULL.
            $table->foreignId('created_by')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null');
                  
            $table->foreignId('updated_by')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null');

            $table->timestamps();
            $table->softDeletes();
            
            // Index for efficiency and a unique constraint for data integrity
            $table->unique(['tenant_id', 'name']); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
