<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrackingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pointage', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('project_id');
            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();
            $table->timestamp('pause_start_time')->nullable();
            $table->timestamp('pause_end_time')->nullable();
            $table->text('task_description')->nullable();
            $table->decimal('total_worked_hours', 8, 2)->nullable(); // Total worked hours
            $table->decimal('total_pause_hours', 8, 2)->nullable(); // Total pause hours
            $table->string('status')->default('pending'); // Status of the pointage record
            $table->string('location')->nullable(); // Location of clock-in/out
            $table->text('remarks')->nullable(); // Additional remarks
            $table->timestamps();

            // Foreign keys
            $table->foreign('employee_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pointage');
    }
}
