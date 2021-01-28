<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddColumnPendorderDataToCashierPendorderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! RC_Schema::hasTable('cashier_pendorder')) {
            return ;
        }

        //添加字段
        RC_Schema::table('cashier_pendorder', function (Blueprint $table) {
            if (!RC_Schema::hasColumn('cashier_pendorder', 'pendorder_data')) $table->longText('pendorder_data')->comment('挂单购物车数据');
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
        RC_Schema::table('cashier_pendorder', function (Blueprint $table) {
            $table->dropColumn('pendorder_data');
        });
    }
}
