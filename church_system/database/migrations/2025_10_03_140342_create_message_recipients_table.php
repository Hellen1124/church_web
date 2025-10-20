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
        Schema::create('message_recipients', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('message_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('member_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            // Single field for either phone/email
            $table->string('recipient_contact');

            // Delivery tracking
            $table->enum('status', ['pending', 'sent', 'failed'])
                  ->default('pending');

            $table->timestamp('delivered_at')->nullable();
            $table->string('failure_reason')->nullable();
            $table->unsignedInteger('attempts')->default(0);

            $table->timestamps();
        });
           
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('message_recipients');
    }
};
