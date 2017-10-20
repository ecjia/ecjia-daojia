<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreateCashierRecordTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		RC_Schema::create('cashier_record', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('store_id')->unsigned()->default('0');
			$table->integer('staff_id')->unsigned()->default('0');
			$table->integer('order_id')->unsigned()->default('0');
			$table->string('order_type', 60)->comment('ecjia-cashdesk收银台');
			$table->integer('mobile_device_id')->unsigned()->default('0')->comment('对应mobile_device表的id');
			$table->string('device_sn', 60)->comment('设备号');
			$table->string('device_type', 60)->comment('ecjia-cashdesk收银台');
			$table->string('action', 60)->comment('billing开单，receipt收款，check_order验单');
			$table->integer('create_at')->unsigned()->default('0');
			
			$table->index('store_id', 'store_id');
			$table->index('staff_id', 'staff_id');
			$table->index('mobile_device_id', 'mobile_device_id');
			$table->index(array('order_id', 'order_type'), 'order_id');
			$table->index('device_sn', 'device_sn');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		RC_Schema::drop('cashier_record');
	}

}
