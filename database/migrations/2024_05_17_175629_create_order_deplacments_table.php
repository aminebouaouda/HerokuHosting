php artisan make:migration create_order_deplacments_table
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
        Schema::create('order_deplacments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_employee')->nullable()->constrained('users');
            $table->string('localiastion');
            $table->string('titel');
            $table->text('buteDeplacment');
            $table->boolean('is_accepte')->default(false);
            // $table->foreignId('id_charges')->nullable()->constrained('charges');
            $table->string('localisation_verify')->nullable();
            $table->boolean('fine_mission')->default(false);
            $table->boolean('mession_verify')->default(false);
            $table->double('budget_total')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_deolacment');
    }
};
