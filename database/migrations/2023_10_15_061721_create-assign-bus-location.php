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
        Schema::create('assigns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bus_id');
            $table->unsignedBigInteger('location_id_from');
            $table->unsignedBigInteger('location_id_end');
            $table->date('assign_date');
            $table->unsignedBigInteger('assign_by');

            $table->foreign('bus_id')->references('id')->on('buses');
            $table->foreign('location_id_from')->references('id')->on('locations');
            $table->foreign('location_id_end')->references('id')->on('locations');
            $table->foreign('assign_by')->references('id')->on('users');

            $table->timestamps();
        });
    }
   
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assigns');
    }
};
