<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
	        $table->engine = 'InnoDB';

            $table->increments('id');
	        $table->integer('created_at');
	        $table->integer('updated_at');

	        $table->integer('order_id')->unsigned()->index();

	        $table->integer('paid_at');
	        $table->decimal('paid_amount', 8, 2);
	        $table->integer('processed')->default(0);
	        $table->text('payment_data');

	        $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('payments');
    }
}
