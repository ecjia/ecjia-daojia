<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreateCashierDeviceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		RC_Schema::create('cashier_device', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('store_id')->unsigned()->default('0');
			$table->string('device_name', 100)->default('');
			$table->string('device_mac', 100)->comment('MAC');
			$table->string('device_sn', 100)->comment('SN');
			$table->string('device_type', 50)->comment('机型');
			$table->string('product_sn', 100)->comment('设备号');
			$table->string('keyboard_sn', 50)->comment('密码键盘序列号');
			$table->tinyInteger('status')->unsigned()->default('1')->comment('状态 0:关闭 1:开启');
			$table->integer('add_time')->unsigned()->default('0')->comment('添加时间');
			$table->integer('update_time')->unsigned()->default('0')->comment('更新时间');
			
			$table->index('store_id', 'store_id');
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
		RC_Schema::drop('cashier_device');
	}

}
