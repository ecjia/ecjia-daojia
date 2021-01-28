<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddColumnWechatIdToMarketActivity extends Migration {

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

        //添加字段
		RC_Schema::table('market_activity', function(Blueprint $table)
		{
            if (!RC_Schema::hasColumn('market_activity', 'wechat_id')) $table->integer('wechat_id')->unsigned()->default('0')->comment('公众号id')->after('store_id');
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
		RC_Schema::table('market_activity', function(Blueprint $table)
		{
            $table->dropColumn('wechat_id');
		});

	}

}
