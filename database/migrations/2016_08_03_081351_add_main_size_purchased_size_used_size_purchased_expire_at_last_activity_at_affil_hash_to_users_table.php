<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMainSizePurchasedSizeUsedSizePurchasedExpireAtLastActivityAtAffilHashToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
	        $table->bigInteger('main_size')->unsigned();
	        $table->bigInteger('purchased_size')->unsigned();
	        $table->bigInteger('used_size')->unsigned();
	        $table->integer('purchase_expire_at');
	        $table->integer('last_activity_at');
	        $table->char('affil_hash', 8);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
	        $table->dropColumn('main_size');
	        $table->dropColumn('purchased_size');
	        $table->dropColumn('used_size');
	        $table->dropColumn('purchase_expire_at');
	        $table->dropColumn('last_activity_at');
	        $table->dropColumn('affil_hash');
        });
    }
}
