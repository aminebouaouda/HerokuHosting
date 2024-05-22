<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimeTrackingsTable extends Migration
{
    public function up()
    {
        Schema::create('time_trackings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('feuille_name');
            $table->string('project_name');
            $table->string('day_of_week');
            $table->dateTime('start_time')->nullable();
            $table->dateTime('end_time')->nullable();
            $table->string('total_regular_time');
            $table->integer('additional_hours')->nullable(); // Added additional_hours column
            $table->text('comment')->nullable();
            $table->boolean('is_am'); // Added is_am column
            $table->boolean('is_am0'); // Added is_am0 column
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('time_trackings');
    }
}
