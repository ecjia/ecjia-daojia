<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddOrderForStoreBillDetailTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		RC_Schema::table('store_bill_detail', function(Blueprint $table)
		{
		    $table->string('order_sn', 30)->after('order_id');
		    $table->decimal('goods_amount', 10, 2)->default('0.00')->after('order_sn');
		    $table->decimal('shipping_fee', 10, 2)->default('0.00')->comment('配送费')->after('goods_amount');
		    $table->decimal('insure_fee', 10, 2)->default('0.00')->comment('保险费')->after('shipping_fee');
		    $table->decimal('pay_fee', 10, 2)->default('0.00')->comment('支付手续费')->after('insure_fee');
		    $table->decimal('pack_fee', 10, 2)->default('0.00')->comment('包装费用')->after('pay_fee');
		    $table->decimal('card_fee', 10, 2)->default('0.00')->comment('贺卡费用')->after('pack_fee');
		    $table->decimal('surplus', 10, 2)->default('0.00')->comment('余额支付')->after('card_fee');
		    $table->integer('integral')->unsigned()->default('0')->comment('积分')->after('surplus');
		    $table->decimal('integral_money', 10, 2)->default('0.00')->comment('积分金额')->after('integral');
		    $table->decimal('bonus', 10, 2)->default('0.00')->comment('红包金额')->after('integral_money');
		    $table->decimal('discount', 10, 2)->default('0.00')->comment('折扣金额')->after('bonus');
		    $table->decimal('inv_tax', 10, 2)->default('0.00')->comment('发票费用')->after('discount');
		    $table->decimal('order_amount', 10, 2)->default('0.00')->comment('订单金额')->after('inv_tax');
		    $table->decimal('money_paid', 10, 2)->default('0.00')->comment('实付费用')->after('order_amount');
		    $table->string('pay_code', 60)->nullable()->after('money_paid');
		    $table->string('pay_name', 60)->nullable()->after('pay_code');
		    $table->tinyInteger('bill_status')->unsigned()->default('0')->comment('是否结算,0未结算，1已结算')->after('brokerage_amount');
		    $table->integer('bill_time')->unsigned()->default('0')->comment('结算时间')->after('bill_status');
		    $table->decimal('platform_profit', 10, 2)->default('0.00')->comment('平台佣金')->after('brokerage_amount');
		    
		    $table->unique(['order_type', 'order_id'], 'order_id');
		});
		
		RC_Schema::table('store_bill_detail', function(Blueprint $table)
		{
		    $table->dropUnique('store_detail');
		});
		
		$table = RC_DB::getTableFullName('store_bill_detail');
		RC_DB::statement("ALTER TABLE `$table` MODIFY COLUMN `order_type` varchar(30) NOT NULL DEFAULT 'buy' COMMENT 'buy订单,quickpay买单,refund退款' AFTER `store_id`;");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		RC_Schema::table('store_bill_detail', function(Blueprint $table)
		{
		    $table->dropUnique('order_id');
		    
		    $table->dropColumn('order_sn');
		    $table->dropColumn('goods_amount');
		    $table->dropColumn('shipping_fee');
		    $table->dropColumn('insure_fee');
		    $table->dropColumn('pay_fee');
		    $table->dropColumn('pack_fee');
		    $table->dropColumn('card_fee');
		    $table->dropColumn('surplus');
		    $table->dropColumn('integral');
		    $table->dropColumn('integral_money');
		    $table->dropColumn('bonus');
		    $table->dropColumn('discount');
		    $table->dropColumn('inv_tax');
		    $table->dropColumn('order_amount');
		    $table->dropColumn('money_paid');
		    $table->dropColumn('pay_code');
		    $table->dropColumn('pay_name');
		    $table->dropColumn('bill_status');
		    $table->dropColumn('bill_time');
		    $table->dropColumn('platform_profit');
		    
			$table->unique(array('detail_id', 'store_id'), 'store_detail');
		});
		
		$table = RC_DB::getTableFullName('store_bill_detail');
		RC_DB::statement("ALTER TABLE `$table` MODIFY COLUMN `order_type` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '1订单，2退货单' AFTER `store_id`;");
	}

}
