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
        Schema::create('tenant_advanced_amounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('flat_id')->nullable();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->date('date');
            $table->double('amount');
            $table->integer('transaction_type')->default(1);  // 1 for incoming, -1 for outgoing
            $table->integer('status')->default(1)->comment('0=>Created,1=>Confirm,2=Processing,3=>Cancel');
            $table->string('doc_number')->nullable(); //here can be store bill payment id
            $table->string('doc_type')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('flat_id')->references('id')->on('flats');
            $table->foreign('tenant_id')->references('id')->on('tenants');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenant_advaned_amounts');
    }
};
