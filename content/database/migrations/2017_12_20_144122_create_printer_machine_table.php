<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreatePrinterMachineTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		RC_Schema::create('printer_machine', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('store_id')->unsigned()->default('0')->comment('店铺id');
			$table->string('machine_name', 120)->nullable()->comment('打印机名称');
			$table->string('machine_code', 50)->comment('终端编号');
			$table->string('machine_key', 100)->comment('终端密钥');
			$table->string('machine_mobile', 20)->nullable()->comment('打印机插卡手机号');
			$table->string('machine_logo', 255)->nullable()->comment('打印机logo');
			$table->string('voice_type', 10)->default('horn')->comment('蜂鸣器:buzzer,喇叭:horn');
			$table->tinyInteger('voice')->default('1')->comment('[1,2,3] 3种音量设置');
			$table->string('version', 50)->nullable()->comment('打印机型号');
			$table->string('print_width', 10)->nullable()->comment('打印机宽度');
			$table->string('hardware', 20)->nullable()->comment('硬件版本');
			$table->string('software', 20)->nullable()->comment('软件版本');
			$table->string('print_type', 10)->default('btnclose')->comment('开启:btnopen,关闭:btnclose; 按键打印');
			$table->string('getorder', 10)->default('close')->comment('开启:open,关闭:close;接单');
			$table->tinyInteger('online_status')->default('0')->comment('终端状态，1:在线，2:缺纸，0：离线');
			$table->integer('online_update_time')->unsigned()->default('0')->comment('在线更新时间');
			$table->integer('add_time')->unsigned()->default('0')->comment('添加日期');
			$table->tinyInteger('enabled')->default('1')->comment('是否启用打印机，默认1开启，1:开启，0：关闭');
			
			$table->unique('machine_code', 'machine_code');
			$table->index('store_id', 'store_id');
			$table->index('enabled', 'enabled');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		RC_Schema::drop('printer_machine');
	}

}
