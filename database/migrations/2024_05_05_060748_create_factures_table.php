<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturesTable extends Migration
{
    public function up()
    {
        Schema::create('factures', function (Blueprint $table) {
            $table->id();
            $table->string('numero')->unique();
            $table->foreignId('employee_id')->constrained('users');
            $table->foreignId('paiement_id')->nullable()->constrained('paiements');
            $table->string('description');
            $table->date('date_emission');
            $table->date('date_echeance')->nullable();
            $table->decimal('montant', 10, 2); // Ajout du montant total de la facture
            // $table->enum('statut', ['Payée', 'En attente', 'Annulée'])->default('En attente'); // Ajout du statut de la facture
            $table->text('notes')->nullable(); // Ajout de champs pour les notes supplémentaires
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('factures');
    }
}
