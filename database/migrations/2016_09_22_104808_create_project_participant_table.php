<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectParticipantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_participant', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->timestamps();

	        $table->integer('project_id')->unsigned();
	        $table->integer('user_id')->unsigned();

            $table->unique(['project_id', 'user_id']);
	        $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
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
        Schema::drop('project_participant');
    }
}
