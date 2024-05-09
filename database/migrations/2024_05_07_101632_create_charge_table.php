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
        Schema::create('charges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_employee')->constrained('users', 'id'); // Specify the referenced column name
            $table->foreignId('id_order_deployment')->constrained('order_deplacments', 'id'); // Specify the referenced column name
            $table->double('budget_total');
            $table->json('images'); // Assuming the images will be stored as a JSON array
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('charges');
    }
};
