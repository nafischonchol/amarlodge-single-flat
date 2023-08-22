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
        Schema::create('rents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('building_id')->nullable();
            $table->unsignedBigInteger('flat_id')->nullable();
            $table->date('date');
            $table->double('rent_amount');
            $table->double('water_bill');
            $table->double('gas_bill');
            $table->double('security_bill')->default(0)->nullable();
            $table->double('garbage_bill')->default(0)->nullable();
            $table->double('service_charge')->default(0)->nullable();
            $table->double('electric_bill')->default(0)->nullable();
            $table->double('other_bill')->default(0)->nullable();
            $table->integer('status')->default(0)->nullable()->comment('0=>Created,1=>Confirm,2=Pending');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('building_id')->references('id')->on('buildings');
            $table->foreign('flat_id')->references('id')->on('flats');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rents');
    }
};
