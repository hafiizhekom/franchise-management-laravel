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
        Schema::create('customer_pembayaran_perpanjangan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->nullable();
            $table->integer('tahun');
            $table->dateTime('payment_date');
            $table->bigInteger('amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_pembayaran_perpanjangan');
    }
};
