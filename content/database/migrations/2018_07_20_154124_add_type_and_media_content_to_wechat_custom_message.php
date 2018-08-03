<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddTypeAndMediaContentToWechatCustomMessage extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		RC_Schema::table('wechat_custom_message', function(Blueprint $table)
		{
            $table->string('type', 20)->default('text')->comment('消息类型')->after('send_time');
            $table->text('media_content')->nullable()->comment('消息内容序列化')->after('type');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		RC_Schema::table('wechat_custom_message', function(Blueprint $table)
		{
            $table->dropColumn('type');
            $table->dropColumn('media_content');
		});
	}

}
