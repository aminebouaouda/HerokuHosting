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
        Schema::create('projects', function (Blueprint $table) {
            $table->id(); // Auto-incrementing id
            $table->string('name'); // Text column for project name (corrected from 'nameproject')
            $table->text('description'); // Text column for description
            $table->string('company_name');
            $table->timestamps(); // Company name referencing the 'CompanyName' column in 'users' table (corrected from 'company_name')
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
