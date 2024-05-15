<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModePaiementsTable extends Migration
{
    public function up()
    {
        Schema::create('mode_paiements', function (Blueprint $table) {
            $table->id();
            $table->string('mode');
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mode_paiements');
    }
}
