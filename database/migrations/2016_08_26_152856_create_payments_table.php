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

            $table->integer('user_id')->unsigned()->index();
            $table->integer('variable_symbol')->nullable()->unsigned();
            $table->enum('status', ['incomer', 'partly', 'complete'])->default('incomer');

            $table->integer('paid_at');
            $table->decimal('paid_amount', 8, 2)->default(0);
            $table->decimal('amount_remain', 8, 2)->default(0);

            $table->text('payment_data');

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
        Schema::drop('payments');
    }
}
