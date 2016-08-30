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
	    Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('purchased_size');
            $table->bigInteger('paid_size')->unsigned()->after('main_size');

            $table->dropColumn('purchase_expire_at');
            $table->integer('paid_expire_at')->after('paid_size');

            $table->bigInteger('ordered_unpaid_size')->unsigned()->after('paid_expire_at');
            $table->integer('ordered_unpaid_expire_at')->after('ordered_unpaid_size');

            $table->dropColumn('order_size');
            $table->bigInteger('ordered_size')->unsigned()->after('free_size');

            $table->dropColumn('order_period');
            $table->enum('ordered_period', ['monthly', 'yearly'])->default('yearly')->after('ordered_size');

            $table->dropColumn('renew_active');

	    });

        Schema::table('users', function (Blueprint $table) {
            $table->integer('renew_active')->default(0)->after('ordered_period');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    //DB::statement("ALTER TABLE users CHANGE COLUMN paid_size purchased_size BIGINT(20) unsigned NOT NULL");
	    Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('paid_size');
            $table->bigInteger('purchased_size')->unsigned()->after('main_size');

            $table->dropColumn('paid_expire_at');
            $table->integer('purchase_expire_at')->after('purchased_size');

            $table->dropColumn('ordered_unpaid_size');
            $table->dropColumn('ordered_unpaid_expire_at');

            $table->dropColumn('ordered_size');
            $table->bigInteger('order_size')->unsigned();

            $table->dropColumn('ordered_period');
            $table->enum('order_period', ['monthly', 'yearly'])->default('yearly');
	    });

        // renew_active is not need drop, in up method is only moved
    }
}
