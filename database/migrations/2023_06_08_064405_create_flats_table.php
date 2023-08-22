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
        Schema::create('flats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('building_id')->nullable();
            $table->string('floor')->nullable()->comment('What floor is this flat on?');
            $table->string('name');
            $table->double('area')->default(1);
            $table->double('parking_area')->nullable();
            $table->integer('room')->comment('How many room');
            $table->integer('washroom')->comment('How many washroom');
            $table->boolean('balcony')->comment('Is corridor exist');
            $table->string('utilities')->nullable()->comment('Gas,water,electricty ect.');
            $table->boolean('booked')->default(0)->comment('flat sold or not');
            $table->date('move_out_date')->nullable()->default(null);
            $table->string('flat_for')->default('Rent')->comment('Sell or rent');
            $table->double('rental')->default(0);
            $table->boolean('rented_to_bachelors')->default(0)->comment('Is rent to bechelors?');
            $table->integer('minimumStay')->default(1)->comment('Default 1 month');
            $table->text('notes')->nullable();
            $table->text('termsAndCondition')->nullable();
            $table->text('image')->nullable();
            $table->json('images')->nullable();
            $table->text('youtube_video')->nullable();

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
        Schema::dropIfExists('flats');
    }
};
