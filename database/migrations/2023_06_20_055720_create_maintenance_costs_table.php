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
        Schema::create('maintenance_costs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('building_id')->nullable();
            $table->string('title');
            $table->date('date');
            $table->double('amount')->default(500);
            $table->text('details')->nullable();
            $table->string('image')->nullable();
            $table->string('payment_method')->default('Cash');
            $table->string('recevier_number')->nullable();
            $table->string('transection_id')->nullable();
            $table->string('from_account')->nullable();
            $table->string('to_account')->nullable();
            $table->string('bill_payer')->default('Owner')->nullable();
            $table->json('checked_flats')->nullable();
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
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
        Schema::dropIfExists('maintenance_costs');
    }
};
