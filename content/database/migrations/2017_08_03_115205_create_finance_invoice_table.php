<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreateFinanceInvoiceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		RC_Schema::create('finance_invoice', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned()->default('0')->comment('用户id');
			$table->string('title_name', 60)->comment('抬头名称');
			$table->string('title_type', 20)->default('PERSONAL')->comment('抬头类型: PERSONAL（个人） CORPORATION（单位）');
			$table->string('user_mobile', 20)->nullable()->comment('电话号码');
			$table->string('tax_register_no', 60)->nullable()->comment('纳税人识别号');
			$table->string('user_address', 100)->nullable()->comment('详细地址');
			$table->string('open_bank_name', 100)->nullable()->comment('开户银行');
			$table->string('open_bank_account', 100)->nullable()->comment('银行账号');
			$table->integer('add_time')->unsigned()->default('0')->comment('添加时间');
			$table->integer('update_time')->unsigned()->default('0')->comment('更新时间');
			$table->tinyInteger('is_default')->unsigned()->default('0')->comment('0非默认，1默认');
			$table->tinyInteger('status')->unsigned()->default('1')->comment('0 待审核，1 审核通过');

			$table->index('user_id', 'user_id');
			$table->index('status', 'status');
			$table->index('user_mobile', 'user_mobile');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		RC_Schema::drop('finance_invoice');
	}

}
