<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreateWechatCustomerRecordTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		RC_Schema::create('wechat_customer_record', function(Blueprint $table)
		{
			$table->increments('id');
            $table->integer('wechat_id')->unsigned()->default('0');
			$table->string('kf_account', 60)->comment('客服账号');
			$table->string('openid', 60)->comment('用户openid');
            $table->integer('opercode')->unsigned()->default('0')->comment('会话状态');
            $table->string('text', 255)->comment('发送内容');
            $table->integer('time')->unsigned()->default('0')->comment('发送时间');

            $table->index('kf_account', 'kf_account');
            $table->index('openid', 'openid');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		RC_Schema::drop('wechat_customer_record');
	}

}
