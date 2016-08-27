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

            $table->integer('start_period_at');
            $table->integer('finish_period_at');
            $table->integer('paid_period_to_at');

            $table->enum('period', ['monthly', 'yearly'])->default('yearly');
            $table->bigInteger('ordered_size')->unsigned();
            $table->integer('price_per_period')->unsigned()->default(0);
            $table->decimal('paid_amount_total', 8, 2)->default(0);

            $table->integer('variable_symbol')->nullable()->unsigned();

            $table->enum('status', ['unpaid', 'partly_complete', 'complete', 'cancelled'])->default('unpaid');

            $table->text('description');

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
        Schema::drop('orders');
    }
}
