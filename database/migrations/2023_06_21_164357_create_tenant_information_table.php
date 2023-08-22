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
        Schema::create('tenant_information', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('building_id');
            $table->unsignedBigInteger('flat_id');
            $table->unsignedBigInteger('tenant_id');
            $table->string('name');
            $table->string('father_name');
            $table->date('dob');
            $table->string('marital_status');
            $table->text('permanent_address');
            $table->string('profession')->nullable();
            $table->text('institute_address')->nullable();
            $table->string('religion');
            $table->string('educational_qualification')->nullable();
            $table->string('mobile');
            $table->string('email')->nullable();
            $table->string('nid');
            $table->string('passport_number')->nullable();
            $table->string('emergency_name');
            $table->string('emergency_mobile');
            $table->text('emergency_address');
            $table->string('emergency_relation');
            $table->string('image')->nullable();
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
        Schema::dropIfExists('tenant_information');
    }
};
