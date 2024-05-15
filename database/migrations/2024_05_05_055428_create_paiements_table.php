<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaiementsTable extends Migration
{
    public function up()
    {
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('users');
            $table->foreignId('mode_paiement_id')->constrained('mode_paiements');
            $table->enum('type_salaire', ['Salaire de base', 'Heures supplémentaires', 'Prime', 'Autre'])->nullable();
            $table->string('periode_paiement')->nullable();
            $table->text('remarques')->nullable();
            $table->enum('statut', ['Payé', 'En attente', 'Annulé'])->default('En attente');
            $table->decimal('montant', 10, 2);
            $table->date('date_paiement');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('paiements');
    }
}
