<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreateStoreAccountLogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		RC_Schema::create('store_account_log', function(Blueprint $table)
		{
			$table->increments('log_id');
			$table->integer('store_id');
			$table->decimal('store_money', 10, 2)->default('0.00')->comment('商家余额');
			$table->decimal('money', 10, 2)->default('0.00')->comment('变动金额');
			$table->decimal('frozen_money', 10, 2)->default('0.00')->comment('冻结资金');
			$table->integer('points')->default('0');
			$table->integer('change_time')->unsigned()->default('0');
			$table->string('change_desc', 255)->nullable();
			$table->string('change_type', 20)->comment('charge充值，withdraw提现，bill结算');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		RC_Schema::drop('store_account_log');
	}

}
