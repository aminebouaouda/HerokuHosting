<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveEnumValuesFromPaiementsTable extends Migration
{
    public function up()
    {
        Schema::table('paiements', function (Blueprint $table) {
            $table->string('type_salaire')->nullable()->change();
        });
    }

    public function down()
    {
        // If you want to revert the change, you can add the enum constraint back in the down method.
        Schema::table('paiements', function (Blueprint $table) {
            $table->enum('type_salaire', ['Salaire de base', 'Heures supplémentaires', 'Prime', 'Autre'])->nullable();
        });
    }
}
