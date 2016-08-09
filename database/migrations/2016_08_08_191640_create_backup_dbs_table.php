<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBackupDbTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('backup_dbs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('created_at');
            $table->integer('updated_at');
            $table->string('filename', 255);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('backup_dbs');
    }
}
