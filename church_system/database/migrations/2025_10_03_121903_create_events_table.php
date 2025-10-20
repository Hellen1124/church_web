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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            // Tenant scoping
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');

            // Event details
            $table->string('name');
            $table->string('slug')->nullable()->unique(); // optional, useful for URLs
            $table->text('description')->nullable();
            $table->string('location')->nullable();

            // Scheduling
            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();

            // Management
            $table->unsignedInteger('capacity')->nullable(); // optional max capacity
            $table->boolean('is_public')->default(true);     // public or internal event

            // Extra flexibility
            $table->json('metadata')->nullable();

            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
