<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSentFeuilleTable extends Migration
{
    public function up()
    {
        Schema::create('sent_feuille', function (Blueprint $table) {
            $table->id();
            $table->string('feuille_name');
            $table->integer('user_id');
            $table->time('total_regular_time');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sent_feuille');
    }
}
