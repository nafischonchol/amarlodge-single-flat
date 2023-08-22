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
        Schema::create('account_balances', function (Blueprint $table) {
            $table->id();
            $table->string('bank_type');
            $table->double('amount');
            $table->integer('transaction_type')->default(1);  // 1 for incoming, -1 for outgoing
            $table->string('note')->nullable();
            $table->string('doc_number')->nullable(); //here can be store payment id
            $table->string('doc_type')->nullable();
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_balances');
    }
};
