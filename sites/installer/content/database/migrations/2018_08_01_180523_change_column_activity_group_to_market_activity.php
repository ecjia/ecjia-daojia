<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class ChangeColumnActivityGroupToMarketActivity extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        if (! RC_Schema::hasTable('market_activity')) {
            return ;
        }

        //修改字段
        $table = RC_DB::getTableFullName('market_activity');
        RC_DB::statement("ALTER TABLE `$table` CHANGE `activity_group` `activity_group` varchar(60)  NOT NULL  DEFAULT '' COMMENT 'mobile_shake摇一摇,wechat_dazhuanpan微信大转盘,wechat_guaguale微信刮刮乐,wechat_zajindan微信砸金蛋';");
        RC_DB::statement("ALTER TABLE `$table` CHANGE `activity_object` `activity_object` varchar(60)  NOT NULL  DEFAULT 'app' COMMENT '活动对象（app，wechat，pc，touch等）';");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{

	}

}
