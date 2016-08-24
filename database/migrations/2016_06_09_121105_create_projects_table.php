<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('created_at');
            $table->integer('updated_at');

            $table->integer('user_id')->unsigned()->index();
            $table->integer('priority')->default(0);
            $table->string('hash', 32);
            $table->string('name', 255);
            $table->string('key', 10);
            $table->text('description')->nullable();

            $table->integer('last_task_id')->unsigned()->default(0);

            $table->unique('hash');
            $table->unique(['user_id', 'name']);
            $table->unique(['user_id', 'key']);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('projects');
    }
}
