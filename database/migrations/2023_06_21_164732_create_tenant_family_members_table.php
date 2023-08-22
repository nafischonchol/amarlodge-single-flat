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
        Schema::create('tenant_family_members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_information_id');
            $table->string('member_name');
            $table->integer('member_age');
            $table->string('member_profession')->nullable();
            $table->string('member_mobile')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('tenant_information_id')->references('id')->on('tenant_information')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenant_family_members');
    }
};
