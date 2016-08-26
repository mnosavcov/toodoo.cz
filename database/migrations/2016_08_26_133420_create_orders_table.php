<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders', function (Blueprint $table) {
			$table->engine = 'InnoDB';

			$table->increments('id');
			$table->integer('created_at');
			$table->integer('updated_at');

			$table->integer('user_id')->unsigned()->index();
			$table->integer('additional_for_order_id')->unsigned()->index()->nullable();

			$table->integer('cancelled_at')->nullable();
			$table->integer('from_period_at');
			$table->integer('end_period_at');

			$table->enum('period', ['additional', 'monthly', 'yearly'])->nullable();
			$table->bigInteger('ordered_size')->unsigned();
			$table->integer('price_per_period')->unsigned();
			$table->decimal('paid_amount_total', 8, 2);

			$table->integer('variable_symbol')->unsigned();

			$table->integer('active')->default(1);
			$table->integer('complete')->default(0)->comment('not renew if true');

			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->foreign('additional_for_order_id')->references('id')->on('orders')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('orders');
	}
}
