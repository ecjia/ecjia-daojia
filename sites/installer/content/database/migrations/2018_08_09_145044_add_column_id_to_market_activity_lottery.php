<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddColumnIdToMarketActivityLottery extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        if (! RC_Schema::hasTable('market_activity_lottery')) {
            return ;
        }

        //添加字段
		RC_Schema::table('market_activity_lottery', function(Blueprint $table)
		{
            if (!RC_Schema::hasColumn('market_activity_lottery', 'id')) $table->increments('id')->first();
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
