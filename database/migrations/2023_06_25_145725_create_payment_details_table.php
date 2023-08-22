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
        Schema::create('payment_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payment_bill_id');
            $table->unsignedBigInteger('bill_id')->nullable()->comment('Bill id null when previous due bill amount store');
            $table->double('amount');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('payment_bill_id')->references('id')->on('payment_bills');
            $table->foreign('bill_id')->references('id')->on('bills')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_details');
    }
};
