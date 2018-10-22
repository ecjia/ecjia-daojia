<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddCashierTypeToCashierDeviceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        RC_Schema::table('cashier_device', function(Blueprint $table)
        {
            $table->dropIndex('store_id');
            $table->dropIndex('device_sn');
        });

        RC_Schema::table('cashier_device', function (Blueprint $table) {
            $table->string('cashier_type', 60)->comment('收银设备类型（收银台cashier-desk，POS机cashier-pos）')->after('keyboard_sn');

            $table->unique(['store_id', 'device_sn'], 'store_device_sn');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RC_Schema::table('cashier_device', function (Blueprint $table) {
            $table->dropColumn('cashier_type');

            $table->dropIndex('store_device_sn');
        });

        RC_Schema::table('cashier_device', function(Blueprint $table)
        {
            $table->index('store_id', 'store_id');
            $table->index('device_sn', 'device_sn');
        });
    }
}
