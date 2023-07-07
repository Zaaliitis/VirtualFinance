<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('crypto_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wallet_id');
            $table->unsignedBigInteger('crypto_id');
            $table->enum('type', ['buy', 'sell']);
            $table->decimal('amount');
            $table->decimal('price');

            $table->timestamps();
        });
    }

    public function down(): void
    {
    }
};
