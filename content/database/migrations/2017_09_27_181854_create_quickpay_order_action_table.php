<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreateQuickpayOrderActionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		RC_Schema::create('quickpay_order_action', function(Blueprint $table)
		{
			$table->increments('action_id');
			$table->integer('order_id')->unsigned()->default('0')->comment('所属订单');
			$table->integer('action_user_id')->unsigned()->default('0')->comment('操作者用户id');
			$table->string('action_user_name', 60)->nullable()->comment('操作者用户名称');
			$table->string('action_user_type', 60)->nullable()->comment('操作用户类型');
			$table->tinyInteger('order_status')->default('0')->comment('订单状态 0未确认1已确认');
			$table->tinyInteger('pay_status')->default('0')->comment('支付状态 0未支付1已支付');
			$table->tinyInteger('verification_status')->default('0')->comment('核销状态 0未核销1已核销');
			$table->string('action_note', 255)->nullable()->comment('操作备注');
			$table->integer('add_time')->comment('操作时间');
			
			$table->index('order_id', 'order_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		RC_Schema::drop('quickpay_order_action');
	}

}
