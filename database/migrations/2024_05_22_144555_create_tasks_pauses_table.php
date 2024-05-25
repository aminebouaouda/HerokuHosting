<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksPausesTable extends Migration
{
    public function up()
    {
        Schema::create('tasks_pauses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('timesheet_id');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('type', 20);
            $table->string('note')->nullable();
            $table->string('project_name')->nullable();
            $table->timestamps();

            $table->foreign('timesheet_id')->references('id')->on('timesheets')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tasks_pauses');
    }
}