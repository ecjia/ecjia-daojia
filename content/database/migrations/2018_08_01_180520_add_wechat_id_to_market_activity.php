<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddWechatIdToMarketActivity extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        RC_Schema::table('market_activity', function(Blueprint $table)
        {
            $table->dropIndex('activity_group');
        });


		RC_Schema::table('market_activity', function(Blueprint $table)
		{
            $table->integer('wechat_id')->unsigned()->default('0')->comment('公众号id')->after('store_id');

            $table->unique(['store_id', 'wechat_id', 'activity_group'], 'store_wechat_activitygroup');
		});

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
		RC_Schema::table('market_activity', function(Blueprint $table)
		{
            $table->dropColumn('wechat_id');
		});

        RC_Schema::table('market_activity', function(Blueprint $table)
        {
            $table->dropUnique('store_wechat_activitygroup');

            $table->index('activity_group', 'activity_group');
        });
	}

}
