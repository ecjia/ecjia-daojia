<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreatePrinterPrintlistTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		RC_Schema::create('printer_printlist', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('store_id')->unsigned()->default('0')->comment('店铺id');
			$table->string('order_sn', 60)->comment('订单编号');
			$table->string('order_type', 20)->default('buy')->comment('订单类型，订单支付buy，闪惠订单quickpay');
			$table->string('print_order_id', 60)->nullable()->comment('打印订单id');
			$table->string('machine_code', 50)->comment('终端编号');
			$table->string('template_code', 50)->comment('模版代号');
			$table->text('content')->nullable()->comment('打印内容');
			$table->tinyInteger('print_count')->unsigned()->default('1')->comment('打印次数，默认1');
			$table->integer('print_time')->unsigned()->default('0')->comment('打印时间');
			$table->tinyInteger('status')->default('0')->comment('0待打印，1打印完成，2打印异常，10取消打印');
			$table->tinyInteger('priority')->default('1')->comment('0 延迟发送，1 优先发送');
			$table->string('last_error_message', 255)->nullable()->comment('最后一次错误消息');
			$table->integer('last_send')->unsigned()->default('0');
			
			$table->index(['order_sn', 'order_type'], 'order_sn');
			$table->index('template_code', 'template_code');
			$table->index('store_id', 'store_id');
			$table->index(['machine_code', 'print_order_id'], 'machine_code');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		RC_Schema::drop('printer_printlist');
	}

}
