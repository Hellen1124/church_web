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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            // Tenant scoping
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');

            // Core identity
            $table->string('membership_no')->nullable(); // CH-0001 etc
            $table->string('first_name');
            $table->string('last_name');
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->date('date_of_birth')->nullable();

            // Contact
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();

            // Spiritual / membership details
            $table->date('date_joined')->nullable();
            $table->enum('status', ['active', 'inactive', 'visitor', 'transferred', 'deceased'])
                ->default('active');
            $table->date('baptism_date')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->string('role')->default('member'); // elder, treasurer, pastor, etc.

            $table->timestamps();
            $table->softDeletes();
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
