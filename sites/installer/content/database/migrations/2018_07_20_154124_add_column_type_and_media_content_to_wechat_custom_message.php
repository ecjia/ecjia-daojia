<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddColumnTypeAndMediaContentToWechatCustomMessage extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        if (! RC_Schema::hasTable('wechat_custom_message')) {
            return ;
        }

        //添加字段
		RC_Schema::table('wechat_custom_message', function(Blueprint $table)
		{
            if (!RC_Schema::hasColumn('wechat_custom_message', 'type')) $table->string('type', 20)->default('text')->comment('消息类型')->after('send_time');
            if (!RC_Schema::hasColumn('wechat_custom_message', 'media_content')) $table->text('media_content')->nullable()->comment('消息内容序列化')->after('type');
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
		RC_Schema::table('wechat_custom_message', function(Blueprint $table)
		{
            $table->dropColumn('type');
            $table->dropColumn('media_content');
		});
	}

}
