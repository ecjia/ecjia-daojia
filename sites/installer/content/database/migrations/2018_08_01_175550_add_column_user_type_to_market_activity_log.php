<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddColumnUserTypeToMarketActivityLog extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        if (! RC_Schema::hasTable('market_activity_log')) {
            return ;
        }

        //添加字段
		RC_Schema::table('market_activity_log', function(Blueprint $table)
		{
            if (!RC_Schema::hasColumn('market_activity_log', 'user_type')) $table->string('user_type', 60)->nullable()->default('user')->comment('用户类型，user普通会员，wechat微信用户')->after('user_id');
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
		RC_Schema::table('market_activity_log', function(Blueprint $table)
		{
            $table->dropColumn('user_type');
		});
	}

}
