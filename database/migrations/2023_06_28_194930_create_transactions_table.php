<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('sender_account_id');;
            $table->integer('receiver_account_id');;
            $table->decimal('amount', 16, 2);
            $table->string('description');
            $table->timestamps();
        });
    }


    public function down(): void
    {

    }
};
