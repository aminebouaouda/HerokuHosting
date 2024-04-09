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
        Schema::create('vacation', function (Blueprint $table) {
            $table->id();
            $table->string('titel')->nullable();
            $table->string('remarque')->nullable();
            $table->string('file');
            $table->integer('isaccept')->default(0);
            $table->date('date_demande');
            $table->unsignedBigInteger('id_employee'); 

            // Define foreign key constraint
            $table->foreign('id_employee')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_vacation');
    }
};
