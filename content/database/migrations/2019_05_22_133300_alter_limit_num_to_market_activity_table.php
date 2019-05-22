<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AlterLimitNumToMarketActivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $table = RC_DB::getTableFullName('market_activity');

        RC_DB::statement("ALTER TABLE `$table` MODIFY `limit_num` TINYINT(3) UNSIGNED NOT NULL DEFAULT '0' COMMENT '活动限制次数（0为不限制）';");
        RC_DB::statement("ALTER TABLE `$table` MODIFY `enabled` TINYINT(3) UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否使用，1开启，0禁用';");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RC_Schema::table('market_activity', function (Blueprint $table) {
            //
        });
    }
}
