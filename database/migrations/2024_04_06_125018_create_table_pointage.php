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
        Schema::create('pointage', function (Blueprint $table) {
            $table->id();
            $table->time('morning_entry');
            $table->time('morning_exit');
            $table->time('evening_entry');
            $table->time('evening_exit');
            $table->integer('totale_hours');
            $table->integer('extra_hours');
            $table->date('date_pointage');
            $table->unsignedBigInteger('id_pointeur'); 
            $table->unsignedBigInteger('id_employee'); 

            // Define foreign key constraint
            $table->foreign('id_pointeur')->references('id')->on('users');
            $table->foreign('id_employee')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_pointage');
    }
};
