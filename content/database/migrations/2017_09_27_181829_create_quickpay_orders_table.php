<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreateQuickpayOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		RC_Schema::create('quickpay_orders', function(Blueprint $table)
		{
			$table->increments('order_id');
			$table->string('order_sn', 30)->comment('订单编号');
			$table->string('order_type', 60)->comment('订单类型');
			$table->integer('store_id')->unsigned()->default('0')->comment('店铺id');
			$table->integer('add_time')->unsigned()->default('0')->comment('买单时间');
			$table->string('activity_type', 60)->nullable()->comment('优惠类型');
			$table->integer('activity_id')->unsigned()->default('0')->comment('闪惠活动id');
			$table->integer('user_id')->unsigned()->default('0')->comment('用户id');
			$table->string('user_type', 60)->nullable()->comment('用户类型');
			$table->string('user_name', 60)->nullable()->comment('购买人姓名');
			$table->string('user_mobile', 60)->nullable()->comment('购买人电话');
			$table->decimal('goods_amount', 10, 2)->default('0.00')->comment('消费金额');
			$table->decimal('discount', 10, 2)->default('0.00')->comment('闪惠金额');
			$table->integer('integral')->unsigned()->default('0')->comment('积分数量');
			$table->decimal('integral_money', 10, 2)->default('0.00')->comment('积分金额');
			$table->decimal('surplus', 10, 2)->default('0.00')->comment('余额使用');
			$table->decimal('bonus', 10, 2)->default('0.00')->comment('红包抵扣');
			$table->integer('bonus_id')->unsigned()->default('0')->comment('红包id');
			$table->decimal('order_amount', 10, 2)->default('0.00')->comment('实付金额');
			$table->tinyInteger('order_status')->default('0')->comment('订单状态 0未确认1已确认');
			$table->string('pay_code', 60)->nullable()->comment('支付代号');
			$table->string('pay_name', 60)->nullable()->comment('支付名称');
			$table->string('pay_time', 60)->nullable()->comment('支付时间');
			$table->tinyInteger('pay_status')->default('0')->comment('支付状态 0未支付 1已支付');
			$table->integer('verification_time')->unsigned()->default('0')->comment('核销时间');
			$table->tinyInteger('verification_status')->default('0')->comment('核销状态 0未核销1已核销');
			$table->string('referer', 255)->nullable()->comment('订单来源');
			$table->string('from_ad', 20)->nullable()->comment('订单由某广告带来的广告id');
			
			$table->unique('order_sn', 'order_sn');
			$table->unique(['store_id', 'order_id'], 'store_order');
			$table->index('store_id', 'store_id');
			$table->index('user_id', 'user_id');
			$table->index('pay_code', 'pay_code');
			$table->index('activity_type', 'activity_type');
			$table->index('activity_id', 'activity_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		RC_Schema::drop('quickpay_orders');
	}

}
