<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('task_title');
            $table->text('task_desc')->nullable();
            $table->Integer('task_category_id');
            $table->Integer('task_added_by');
            $table->Integer('task_responsible');
            $table->Date('task_start_date');
            $table->Date('task_due_date');
            $table->TinyInteger('task_status')->default(0);
            $table->Integer('task_priority')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
