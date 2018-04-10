<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreateStoreBillQueueTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		RC_Schema::create('store_bill_queue', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('order_type', 30)->default('buy')->comment('buy订单,quickpay买单,refund退款');
			$table->integer('order_id')->unsigned()->default('0');
			$table->tinyInteger('priority')->default('0')->comment('优先级');
			$table->integer('add_time')->unsigned()->default('0');
			
			$table->unique(['order_type', 'order_id'], 'unique_order');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		RC_Schema::drop('store_bill_queue');
	}

}
