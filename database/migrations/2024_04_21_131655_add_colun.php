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
        Schema::table('pointages', function (Blueprint $table) {
            // Check if the column exists before adding foreign key
            if (!Schema::hasColumn('pointages', 'id_employee')) {
                $table->unsignedBigInteger('id_employee');

                // Define foreign key constraint
                $table->foreign('id_employee')->references('id')->on('users')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pointages', function (Blueprint $table) {
            // Drop foreign key constraint
            $table->dropForeign(['id_employee']);

            // Drop the column if it exists
            if (Schema::hasColumn('pointages', 'id_employee')) {
                $table->dropColumn('id_employee');
            }
        });
    }
};