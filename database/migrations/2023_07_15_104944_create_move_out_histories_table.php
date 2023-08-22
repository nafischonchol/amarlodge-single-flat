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
        Schema::create('move_out_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('flat_id')->nullable();
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->string('rent_month');
            $table->date('move_out_date');
            $table->integer('status')->default('1');
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
        Schema::dropIfExists('move_out_histories');
    }
};
