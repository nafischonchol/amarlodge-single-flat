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
        Schema::create('committes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('building_id')->nullable();
            $table->string('name');
            $table->string('mobile');
            $table->string('email');
            $table->string('present_address');
            $table->string('permanent_address')->nullable();
            $table->string('nid');
            $table->string('designation')->nullable();
            $table->integer('status');
            $table->date('joining_date');
            $table->date('end_date')->nullable();
            $table->text('details_info')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('building_id')->references('id')->on('buildings')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('committes');
    }
};
