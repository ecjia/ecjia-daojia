<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddIndexActivityUserIdToMarketActivityLotteryTable extends Migration
{
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

        RC_Schema::table('market_activity_lottery', function (Blueprint $table) {
            if (!$table->hasIndex('activity_user_id')) $table->unique(['activity_id', 'user_id', 'user_type'], 'activity_user_id');
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
