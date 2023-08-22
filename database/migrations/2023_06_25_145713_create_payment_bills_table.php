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
        Schema::create('payment_bills', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('building_id');
            $table->unsignedBigInteger('flat_id');
            $table->string('payment_method')->default('Cash');
            $table->string('receiver_number')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('from_account')->nullable();
            $table->string('to_account')->nullable();
            $table->double('total_amount')->default(0)->comment('This is total amount that should paid,but user can pay less.');
            $table->double('pay_amount')->default(0)->comment('User paid amount');
            $table->double('use_advanced_amount')->default(0);
            $table->double('discount_amount')->default(0);
            $table->double('due_amount')->default(0);
            $table->date('date');
            $table->integer('status')->default(2)->comment('0=>Created,1=>Confirm,2=Pending');
            $table->string('note')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('building_id')->references('id')->on('buildings')->onDelete('cascade');
            $table->foreign('flat_id')->references('id')->on('flats');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_bills');
    }
};
