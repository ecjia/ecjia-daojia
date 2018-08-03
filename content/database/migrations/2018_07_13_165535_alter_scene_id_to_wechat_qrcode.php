<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AlterSceneIdToWechatQrcode extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		RC_Schema::table('wechat_qrcode', function(Blueprint $table)
		{
            $table = RC_DB::getTableFullName('wechat_qrcode');
            RC_DB::statement("ALTER TABLE `$table` MODIFY COLUMN `scene_id` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '场景值ID，临时二维码时为32位非0整型，永久二维码时最大值为100000（目前参数只支持1--100000）';");
            RC_DB::statement("ALTER TABLE `$table` MODIFY COLUMN `expire_seconds` int(10) NOT NULL DEFAULT '0' COMMENT '二维码有效时间';");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        //No need to undo changes
	}

}
