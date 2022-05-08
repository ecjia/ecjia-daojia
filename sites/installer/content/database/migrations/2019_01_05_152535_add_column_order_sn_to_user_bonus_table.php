<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddColumnOrderSnToUserBonusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! RC_Schema::hasTable('user_bonus')) {
            return ;
        }

        //添加字段
        RC_Schema::table('user_bonus', function (Blueprint $table) {
            if (!RC_Schema::hasColumn('user_bonus', 'order_sn')) $table->string('order_sn', 60)->nullable()->comment('订单号SN')->after('order_id');
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
        RC_Schema::table('user_bonus', function (Blueprint $table) {
            $table->dropColumn('order_sn');
        });
    }
}
