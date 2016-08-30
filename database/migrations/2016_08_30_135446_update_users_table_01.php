<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersTable01 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    DB::statement("ALTER TABLE users CHANGE COLUMN purchased_size paid_size BIGINT(20) unsigned NOT NULL");

//	    Schema::table('users', function (Blueprint $table) {
//
//		    //$table->renameColumn('purchased_size', 'paid_size');
//	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    DB::statement("ALTER TABLE users CHANGE COLUMN paid_size purchased_size BIGINT(20) unsigned NOT NULL");
//	    Schema::table('users', function (Blueprint $table) {
//		    //$table->renameColumn('paid_size', 'purchased_size');
//	    });
    }
}
