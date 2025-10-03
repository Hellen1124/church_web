<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtpsTable extends Migration
{
    public function up()
    {
        Schema::create('otps', function (Blueprint $table) {
            $table->bigIncrements('id');

            // phone in E.164 (store as string)
            $table->string('phone', 10)->index();

            // hashed code (bcrypt/argon) or HMAC
            $table->string('code_hash', 255);

            // optional secret/nonce if using HMAC approach (nullable)
            $table->string('secret', 64)->nullable();

            // provider name (fakesms/twilio) for audit, optional
            $table->string('provider')->nullable();

            // current verification attempts
            $table->unsignedTinyInteger('attempts')->default(0);

            // mark when this OTP has been used successfully
            $table->timestamp('used_at')->nullable();

            // expiry timestamp
            $table->timestamp('expires_at')->nullable()->index();

            $table->timestamps();

            // small composite for lookups
            $table->index(['phone', 'expires_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('otps');
    }
}

