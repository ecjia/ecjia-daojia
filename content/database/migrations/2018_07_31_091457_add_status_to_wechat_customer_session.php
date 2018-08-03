<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddStatusToWechatCustomerSession extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    //添加字段
		RC_Schema::table('wechat_customer_session', function(Blueprint $table)
		{
            $table->dropColumn('time');
            $table->dropColumn('opercode');
            $table->dropColumn('text');

            $table->integer('create_time')->unsigned()->default('0')->comment('会话创建时间');
            $table->integer('latest_time')->unsigned()->default('0')->comment('粉丝的最后一条消息的时间');
            $table->tinyInteger('status')->unsigned()->default('2')->comment('会话状态 1会话中 2待接入 3已关闭');
		});

        //修改字段
        RC_Schema::table('wechat_customer_session', function(Blueprint $table)
        {
            $table->string('kf_account', 60)->nullable()->default('')->change();
            $table->string('openid', 60)->change();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		RC_Schema::table('wechat_customer_session', function(Blueprint $table)
		{
            $table->dropColumn('create_time');
            $table->dropColumn('latest_time');
            $table->dropColumn('status');

            $table->integer('opercode')->unsigned()->default('0')->comment('会话状态');
            $table->string('text', 255)->comment('发送内容');
            $table->integer('time')->unsigned()->default('0')->comment('发送时间');
		});
	}

}
