<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreatePrinterTemplateTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		RC_Schema::create('printer_template', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('store_id')->unsigned()->default('0')->comment('店铺id');
			$table->string('template_subject', 120)->comment('模版名称');
			$table->string('template_code', 50)->comment('模版代号');
			$table->text('template_content')->comment('模版内容');
			$table->tinyInteger('print_number')->unsigned()->default('1')->comment('打印数量，默认1');
			$table->tinyInteger('status')->default('0')->comment('是否启用此模版，1:是，0：否');
			$table->tinyInteger('auto_print')->default('0')->comment('是否开启自动打印，1:是，0：否');
			$table->text('tail_content')->nullable()->comment('自定义尾部信息');
			$table->integer('last_modify')->unsigned()->default('0')->comment('上次修改时间');
			$table->integer('add_time')->unsigned()->default('0')->comment('添加时间');
			
			$table->unique(array('template_code', 'store_id'), 'template_code');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		RC_Schema::drop('printer_template');
	}

}
