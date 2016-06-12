<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->engine = 'InnoDB';
            
            $table->increments('id');
            $table->integer('created_at');
            $table->integer('updated_at');

            $table->integer('project_id')->unsigned()->index();
            $table->string('hash', 32);
            $table->string('name', 255);
            $table->string('short', 255);
            $table->text('description');

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
        Schema::drop('tasks');
    }
}
