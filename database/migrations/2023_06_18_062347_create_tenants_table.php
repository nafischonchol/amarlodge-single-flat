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
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('building_id')->nullable();
            $table->unsignedBigInteger('flat_id')->nullable();
            $table->string('name');
            $table->double('mobile');
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('nid')->nullable();
            $table->integer('member')->nullable()->comment('Total family member');
            $table->double('advanced_amount')->default(0)->nullable();
            $table->double('rent_per_month')->default(0)->nullable();
            $table->string('issue_date')->nullable();
            $table->string('rent_month')->nullable();
            $table->string('image')->nullable();
            $table->text('additional_notes')->nullable();
            $table->integer('status')->default(1);
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
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
        Schema::dropIfExists('tenants');
    }
};
