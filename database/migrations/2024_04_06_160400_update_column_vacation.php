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
        Schema::table('vacation', function (Blueprint $table) {
            $table->renameColumn('remarque', 'remark');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('your_table_name_here', function (Blueprint $table) {
            $table->renameColumn('remark', 'remarque');
        });
    }
};
