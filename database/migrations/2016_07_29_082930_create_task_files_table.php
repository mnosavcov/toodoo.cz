<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_files', function (Blueprint $table) {
	        $table->engine = 'InnoDB';

	        $table->increments('id');
	        $table->integer('created_at');
	        $table->integer('updated_at');

	        $table->integer('task_id')->unsigned();

	        $table->string('ftp_connection');
	        $table->string('file_md5', 32);
	        $table->string('fullfile', 255);
	        $table->string('pathname', 255);
	        $table->string('filename', 255);
	        $table->string('extname', 32);
	        $table->string('mime_type', 255);
	        $table->string('thumb', 255)->nullable();

	        $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::drop('task_files');
    }
}
