<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreateExpressUserAccountLogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		RC_Schema::create('express_user_account_log', function(Blueprint $table)
		{
			$table->increments('log_id');
			$table->integer('staff_user_id')->unsigned()->default('0')->comment('配送员id,同staff_user表user_id');
			$table->decimal('user_money', 10, 2)->default('0.00')->comment('资金变动金额');
			$table->decimal('frozen_money', 10, 2)->default('0.00')->comment('冻结资金');
			$table->integer('change_time')->unsigned()->default('0')->comment('资金变动时间');
			$table->string('change_desc', 255)->nullable()->comment('资金变动原因');
			$table->tinyInteger('change_type')->unsigned()->default('99')->comment('变动类型,0为充值,1,为提现,2为管理员调节,99为其它类型');
			
			$table->index('staff_user_id', 'staff_user_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		RC_Schema::drop('express_user_account_log');
	}

}
