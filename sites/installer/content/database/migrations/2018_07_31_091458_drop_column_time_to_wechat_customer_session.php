<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class DropColumnTimeToWechatCustomerSession extends Migration {

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

        //删除字段
        RC_Schema::table('wechat_customer_session', function(Blueprint $table)
        {
            if (RC_Schema::hasColumn('wechat_customer_session', 'time')) $table->dropColumn('time');
            if (RC_Schema::hasColumn('wechat_customer_session', 'opercode')) $table->dropColumn('opercode');
            if (RC_Schema::hasColumn('wechat_customer_session', 'text')) $table->dropColumn('text');
        });

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        //添加字段
        RC_Schema::table('wechat_customer_session', function(Blueprint $table)
        {
            $table->integer('opercode')->unsigned()->default('0')->comment('会话状态');
            $table->string('text', 255)->comment('发送内容');
            $table->integer('time')->unsigned()->default('0')->comment('发送时间');
        });
	}

}
