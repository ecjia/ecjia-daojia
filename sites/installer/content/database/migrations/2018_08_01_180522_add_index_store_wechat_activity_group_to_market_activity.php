<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddIndexStoreWechatActivityGroupToMarketActivity extends Migration {

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

        //添加索引
        RC_Schema::table('market_activity', function(Blueprint $table)
        {
            if (!$table->hasIndex('store_wechat_activity_group')) $table->unique(['store_id', 'wechat_id', 'activity_group'], 'store_wechat_activity_group');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{

        //删除索引
        RC_Schema::table('market_activity', function(Blueprint $table)
        {
            if ($table->hasIndex('store_wechat_activity_group')) $table->dropUnique('store_wechat_activity_group');
        });

	}

}
