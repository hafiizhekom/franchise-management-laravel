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
        Schema::create('customer_dana_pelunasan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dana_dp_id')->nullable();
            $table->dateTime('payment_date');
            $table->bigInteger('amount');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_dana_pelunasan');
    }
};
