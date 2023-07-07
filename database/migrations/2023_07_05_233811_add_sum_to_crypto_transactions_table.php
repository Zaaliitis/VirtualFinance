<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('crypto_transactions', function (Blueprint $table) {
            $table->decimal('sum', 30, 10)->after('price');
        });
    }

    public function down(): void
    {

    }
};
