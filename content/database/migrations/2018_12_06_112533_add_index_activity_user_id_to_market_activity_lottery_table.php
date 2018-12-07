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
        RC_Schema::table('market_activity_lottery', function (Blueprint $table) {
            $table->unique(['activity_id', 'user_id', 'user_type'], 'activity_user_id');
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
