<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreateStoreAccountOrderTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		RC_Schema::create('store_account_order', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('store_id')->unsigned()->default('0');
			$table->string('order_sn', 30)->comment('订单编号');
			$table->decimal('amount', 10, 2);
			$table->integer('admin_id')->default('0');
			$table->string('admin_name', 60)->nullable();
			$table->string('admin_note', 255)->nullable();
			$table->string('staff_note', 255)->nullable();
			$table->string('process_type', 20)->default('buy')->comment('charge充值，withdraw提现，bill结算');
			$table->string('pay_code', 60)->nullable();
			$table->string('pay_name', 60)->nullable();
			$table->integer('pay_time')->unsigned()->default('0');
			$table->tinyInteger('pay_status')->default('0');
			$table->tinyInteger('status')->default('1')->comment('1待审核，2通过，3拒绝');
			$table->string('bill_order_type', 20)->nullable()->comment('buy订单,quickpay买单,refund退款');
			$table->integer('bill_order_id')->unsigned()->default('0')->comment('订单id');
			$table->string('bill_order_sn', 30)->nullable()->comment('订单编号');
			$table->string('account_type', 20)->nullable()->comment('账户类型，bank银行，alipay支付宝');
			$table->string('account_name', 60)->nullable()->comment('收款人');
			$table->string('account_number', 60)->nullable()->comment('银行账号');
			$table->string('bank_name', 60)->nullable()->comment('收款银行');
			$table->string('bank_branch_name', 60)->nullable()->comment('开户银行支行名称');
			$table->integer('add_time')->unsigned()->default('0');
			$table->integer('audit_time')->unsigned()->default('0')->comment('审核时间');
			
			$table->index('store_id', 'store_id');
			$table->index('order_sn', 'order_sn');
			$table->index('bill_order_type', 'bill_order_type');
			$table->index('process_type', 'process_type');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		RC_Schema::drop('store_account_order');
	}

}
