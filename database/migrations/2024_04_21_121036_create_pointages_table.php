<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePointagesTable extends Migration
{
    public function up()
    {
        Schema::create('pointages', function (Blueprint $table) {
            $table->id();
            $table->time('time_entry')->nullable();
            $table->time('pause_exit')->nullable();
            $table->time('pause')->nullable();
            $table->time('time_exit')->nullable();
            $table->integer('extra_hours')->nullable();
            $table->date('date_pointage');
            $table->integer('id_employee');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pointages');
    }
}
