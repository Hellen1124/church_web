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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
             // Multi-tenancy
            $table->foreignId('tenant_id')
                ->constrained()
                ->cascadeOnDelete();

            // system user who created/sent the message
            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            // Message details
            $table->string('type')->default('sms'); // sms, email, push
            $table->string('subject')->nullable(); // for email
            $table->text('body');                  // actual message content

            // Status tracking
            $table->enum('status', ['draft', 'queued', 'sent', 'failed'])
                  ->default('draft');

            $table->timestamp('scheduled_at')->nullable(); // for delayed sending
            $table->timestamp('sent_at')->nullable();

            $table->timestamps();
        });
    }
         

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
