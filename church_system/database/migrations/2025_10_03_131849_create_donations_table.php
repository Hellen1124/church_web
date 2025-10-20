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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();

            // Tenant relationship
            $table->foreignId('tenant_id')
                ->constrained()
                ->onDelete('cascade');

            // Donation details
            $table->decimal('amount', 12, 2);
            $table->string('currency', 10)->default('USD');
            $table->string('payment_method')->nullable();
            $table->string('reference')->nullable()->unique();

            // Donor details
            $table->string('donor_name')->nullable();
            $table->string('donor_contact')->nullable();

            // Meta information
            $table->text('notes')->nullable();
            $table->dateTime('received_at')->nullable();
            $table->boolean('reconciled')->default(false);
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
        Schema::dropIfExists('donations');
    }
};
