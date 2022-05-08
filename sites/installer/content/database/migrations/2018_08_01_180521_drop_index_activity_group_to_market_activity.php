<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class DropIndexActivityGroupToMarketActivity extends Migration {

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

        //删除索引
        RC_Schema::table('market_activity', function(Blueprint $table)
        {
            if ($table->hasIndex('activity_group')) $table->dropIndex('activity_group');
        });

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        //添加索引
        RC_Schema::table('market_activity', function(Blueprint $table)
        {
            if (!$table->hasIndex('activity_group')) $table->index('activity_group', 'activity_group');
        });
	}

}
