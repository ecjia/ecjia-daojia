<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class RenameColumnUsernameToMarketActivityLog extends Migration {

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

        //修改字段名称
        RC_Schema::table('market_activity_log', function(Blueprint $table)
        {
            if (RC_Schema::hasColumn('market_activity_log', 'username')) $table->renameColumn('username', 'user_name');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        //重命名字段
        RC_Schema::table('market_activity_log', function(Blueprint $table)
        {
            $table->renameColumn('user_name', 'username');
        });
	}

}
