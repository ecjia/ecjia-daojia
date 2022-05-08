<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddColumnCashierTypeToCashierDeviceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! RC_Schema::hasTable('cashier_device')) {
            return ;
        }

        //添加字段
        RC_Schema::table('cashier_device', function (Blueprint $table) {
            if (!RC_Schema::hasColumn('cashier_device', 'cashier_type')) $table->string('cashier_type', 60)->comment('收银设备类型（收银台cashier-desk，POS机cashier-pos）')->after('keyboard_sn');
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
        RC_Schema::table('cashier_device', function (Blueprint $table) {
            $table->dropColumn('cashier_type');
        });

    }
}
