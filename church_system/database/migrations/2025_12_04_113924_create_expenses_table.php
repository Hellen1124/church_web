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
        Schema::create('expenses', function (Blueprint $table) {
            // In create_expenses_table migration:
$table->id();
$table->unsignedBigInteger('tenant_id');
$table->date('expense_date');
$table->string('expense_number')->unique();
$table->decimal('amount', 10, 2);
$table->unsignedBigInteger('expense_category_id');
$table->text('description');
$table->string('paid_to', 200);
$table->string('payment_method', 50);
$table->string('reference_number', 100)->nullable();
$table->unsignedBigInteger('approved_by')->nullable(); // User ID
$table->unsignedBigInteger('approved_by_2')->nullable(); // User ID  
$table->timestamp('approved_at')->nullable();
$table->boolean('receipt_available')->default(false);
$table->string('receipt_path')->nullable();
$table->enum('status', ['pending', 'approved', 'paid', 'rejected', 'cancelled'])->default('pending');
$table->text('notes')->nullable();
$table->unsignedBigInteger('created_by')->nullable();
$table->unsignedBigInteger('updated_by')->nullable();
$table->timestamps();
$table->softDeletes();

// Foreign keys
$table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
$table->foreign('expense_category_id')->references('id')->on('expense_categories')->onDelete('restrict');
$table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
$table->foreign('approved_by_2')->references('id')->on('users')->onDelete('set null');
$table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
$table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
