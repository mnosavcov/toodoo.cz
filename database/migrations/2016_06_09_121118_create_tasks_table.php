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

			$table->integer('task_status_id')->unsigned();
			$table->integer('project_id')->unsigned()->index();
			$table->integer('task_id')->unsigned();

			$table->integer('priority')->default(0);
			$table->string('hash', 32);
			$table->string('name', 255);
			$table->text('description');

			$table->unique('hash');
			$table->unique(['project_id', 'task_id']);
			$table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
			$table->foreign('task_status_id')->references('id')->on('task_statuses');
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
