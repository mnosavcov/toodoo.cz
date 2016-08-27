<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrderSizeOrderPeriodRenewActiveOverpaymentToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->bigInteger('order_size')->unsigned();
            $table->enum('order_period', ['monthly', 'yearly'])->default('yearly');
            $table->integer('renew_active')->default(0);
            $table->decimal('overpayment', 8, 2)->default(0);
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
            $table->dropColumn('order_size');
            $table->dropColumn('order_period');
            $table->dropColumn('renew_active');
            $table->dropColumn('overpayment');
        });
    }
}
