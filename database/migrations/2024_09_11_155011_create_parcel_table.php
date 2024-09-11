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
        Schema::create('parcel_process', function (Blueprint $table) {
            $table->id();
            $table->integer('parcel_id')->nullable();
            $table->enum('status_process',['collection','switch','returned','missing'])->nullable();
            $table->dateTime('insert_at');
            $table->integer('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parcel_process');
    }
};
