<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('otp_secret_verified')->default(false)->after('otp_secret');
        });
    }

    public function down(): void
    {


    }
};
