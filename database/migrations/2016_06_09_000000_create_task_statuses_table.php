<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_statuses', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('code', 32);
            $table->string('title', 128);

            $table->unique('code');
        });

        DB::table('task_statuses')->insert([
            ['title' => 'todo', 'code' => 'TODO'],
            ['title' => 'in progress', 'code' => 'IN-PROGRESS'],
            ['title' => 'done', 'code' => 'DONE'],
            ['title' => 'reject', 'code' => 'REJECT']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('task_statuses');
    }
}
