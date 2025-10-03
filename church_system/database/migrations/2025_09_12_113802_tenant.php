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
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // owner user

            $table->string('church_name');
            $table->string('chuech_mobile')->nullable(); // note: typo matches your model
            $table->string('church_email')->nullable();
            $table->string('address')->nullable();
            $table->string('logo_image')->nullable();
            $table->string('location')->nullable();
            $table->string('website')->nullable();
            $table->string('vat_pin')->nullable();
            $table->string('kra_pin')->nullable();
            $table->string('domain')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
   
};
