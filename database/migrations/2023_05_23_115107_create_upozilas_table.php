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
        Schema::create('upozilas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('district_id')->unsigned()->nullable(false);
            $table->string('name', 255)->nullable(false);
            $table->string('bn_name', 255)->nullable()->default(null);
            $table->tinyInteger('status')->default(1)->comment('1=>active,0=>deactivate');
            $table->timestamp('created_at')->nullable()->default(null);
            $table->timestamp('updated_at')->nullable()->default(null);

            $table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('upozilas');
    }
};
