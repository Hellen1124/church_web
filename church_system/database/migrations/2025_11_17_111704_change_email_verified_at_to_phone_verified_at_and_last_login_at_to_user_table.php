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
        Schema::table('users', function (Blueprint $table) {
            // 1. Rename 'email_verified_at' to 'phone_verified_at'
            // This is crucial since your verification is based on phone/OTP.
            $table->renameColumn('email_verified_at', 'phone_verified_at');
            
            // 2. Add the 'last_login_at' column
            // It is placed after the password column and is nullable.
            $table->timestamp('last_login_at')->nullable()->after('password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // 1. Reverse the column name change
            $table->renameColumn('phone_verified_at', 'email_verified_at');
            
            // 2. Remove the added column
            $table->dropColumn('last_login_at');
        });
    }
};
