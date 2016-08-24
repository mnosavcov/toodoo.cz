<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_files', function (Blueprint $table) {
	        $table->engine = 'InnoDB';

	        $table->increments('id');
	        $table->integer('created_at');
	        $table->integer('updated_at');

	        $table->integer('project_id')->unsigned();

	        $table->string('ftp_connection');
	        $table->string('file_md5', 32);
	        $table->string('fullfile', 255);
	        $table->string('pathname', 255);
	        $table->string('filename', 255);
	        $table->string('extname', 32);
	        $table->string('mime_type', 255);
            $table->text('thumb')->nullable();
            $table->integer('filesize')->unsigned();

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
	    Schema::drop('project_files');
    }
}
