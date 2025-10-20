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
        Schema::create('event__members', function (Blueprint $table) {
            $table->id();
              $table->foreignId('event_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('member_id')
                ->constrained()
                ->cascadeOnDelete();

            // Tracking flags
            $table->boolean('invited')->default(false);
            $table->timestamp('invited_at')->nullable();

            $table->boolean('notified')->default(false);   // e.g., SMS/Email sent
            $table->timestamp('notified_at')->nullable();

            $table->boolean('attended')->default(false);
            $table->timestamp('attended_at')->nullable();

            $table->text('notes')->nullable(); // remarks about attendance

            $table->timestamps();

            // Ensure a member cannot be duplicated in the same event
            $table->unique(['event_id', 'member_id']);
        });
          
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event__members');
    }
};
