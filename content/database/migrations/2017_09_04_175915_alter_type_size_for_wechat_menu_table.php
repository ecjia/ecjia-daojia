<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AlterTypeSizeForWechatMenuTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		RC_Schema::table('wechat_menu', function(Blueprint $table)
		{
		    $table->string('type', 60)->nullable()->comment('菜单的响应动作类型')->change();
		    $table->string('url', 255)->nullable()->comment('网页链接，view类型必须')->change();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		RC_Schema::table('wechat_menu', function(Blueprint $table)
		{
			$table->string('type', 10)->nullable()->comment('菜单的响应动作类型')->change();
		    $table->string('url', 160)->nullable()->comment('网页链接，view类型必须')->change();
		});
	}

}
