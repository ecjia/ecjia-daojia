<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddColumnStatusToWechatCustomerSession extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        if (! RC_Schema::hasTable('wechat_customer_session')) {
            return ;
        }

	    //添加字段
		RC_Schema::table('wechat_customer_session', function(Blueprint $table)
		{
            if (!RC_Schema::hasColumn('wechat_customer_session', 'create_time')) $table->integer('create_time')->unsigned()->default('0')->comment('会话创建时间');
            if (!RC_Schema::hasColumn('wechat_customer_session', 'latest_time')) $table->integer('latest_time')->unsigned()->default('0')->comment('粉丝的最后一条消息的时间');
            if (!RC_Schema::hasColumn('wechat_customer_session', 'status')) $table->tinyInteger('status')->unsigned()->default('2')->comment('会话状态 1会话中 2待接入 3已关闭');
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        //删除字段
		RC_Schema::table('wechat_customer_session', function(Blueprint $table)
		{
            $table->dropColumn('create_time');
            $table->dropColumn('latest_time');
            $table->dropColumn('status');
		});

	}

}
