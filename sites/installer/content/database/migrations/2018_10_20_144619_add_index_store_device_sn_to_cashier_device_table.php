<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddIndexStoreDeviceSnToCashierDeviceTable extends Migration
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

        //添加索引
        RC_Schema::table('cashier_device', function(Blueprint $table)
        {
            if (!$table->hasIndex('store_device_sn')) $table->unique(['store_id', 'device_sn'], 'store_device_sn');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //删除索引
        RC_Schema::table('cashier_device', function (Blueprint $table) {
            if ($table->hasIndex('store_device_sn')) $table->dropIndex('store_device_sn');
        });

    }
}
