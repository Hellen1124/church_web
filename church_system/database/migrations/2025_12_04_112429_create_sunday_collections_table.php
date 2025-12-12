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
        Schema::create('sunday_collections', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('tenant_id');
    $table->date('collection_date');
    $table->decimal('first_service_amount', 10, 2)->default(0);
    $table->decimal('second_service_amount', 10, 2)->default(0);
    $table->decimal('children_service_amount', 10, 2)->default(0);
    $table->decimal('mobile_mpesa_amount', 10, 2)->default(0);
    $table->decimal('total_amount', 10, 2)->default(0);
    $table->string('counted_by', 100);
    $table->unsignedBigInteger('verified_by')->nullable(); // User ID
    $table->unsignedBigInteger('verified_by_2')->nullable(); // User ID
    $table->decimal('bank_deposit_amount', 10, 2)->default(0);
    $table->date('bank_deposit_date')->nullable();
    $table->string('bank_slip_number', 50)->nullable();
    $table->enum('status', ['pending', 'counted', 'verified', 'banked', 'cancelled'])->default('pending');
    $table->text('notes')->nullable();
    $table->unsignedBigInteger('created_by')->nullable();
    $table->unsignedBigInteger('updated_by')->nullable();
    $table->timestamps();
    $table->softDeletes();
    
    // Foreign keys
    $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
    $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
    $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
    $table->foreign('verified_by')->references('id')->on('users')->onDelete('set null');
    $table->foreign('verified_by_2')->references('id')->on('users')->onDelete('set null');
    
    // Indexes
    $table->index(['tenant_id', 'collection_date']);
    $table->index(['tenant_id', 'status']);
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sunday_collections');
    }
};
