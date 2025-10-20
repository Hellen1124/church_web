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
        Schema::create('group__members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('member_id')
                ->constrained()
                ->cascadeOnDelete();

            // Optional role within the group (e.g., secretary, treasurer, worship leader)
            $table->string('role')->nullable();

            // Track when the member joined or left the group
            $table->timestamp('joined_at')->nullable();
            $table->timestamp('left_at')->nullable();

            $table->timestamps();

            // Ensure a member can't be duplicated in the same group
            $table->unique(['group_id', 'member_id']);
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group__members');
    }
};
