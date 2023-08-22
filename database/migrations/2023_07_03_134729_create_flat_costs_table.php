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
        Schema::create('flat_costs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('building_id')->nullable();
            $table->unsignedBigInteger('flat_id')->nullable();
            $table->date('date');
            $table->double('amount')->default(500);
            $table->text('cause')->nullable();
            $table->string('payment_method')->default('Cash');
            $table->string('recevier_number')->nullable();
            $table->string('transection_id')->nullable();
            $table->string('from_account')->nullable();
            $table->string('to_account')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('building_id')->references('id')->on('buildings');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flat_costs');
    }
};
