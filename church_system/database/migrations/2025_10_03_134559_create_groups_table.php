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
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
                // Multi-tenancy
            $table->foreignId('tenant_id')
                ->constrained()
                ->cascadeOnDelete();
                // Core info
            $table->string('name');              // e.g. Youth, Women Fellowship
            $table->string('slug')->unique();    // useful for URLs or references
            $table->text('description')->nullable();

            // Optional leadership (a member leading the group)
            $table->foreignId('leader_id')
                ->nullable()
                ->constrained('members')
                ->nullOnDelete();

            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes();
        });
          
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};
