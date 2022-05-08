<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class DropIndexStoreIdToCashierDeviceTable extends Migration
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

        //删除索引
        RC_Schema::table('cashier_device', function(Blueprint $table)
        {
            if ($table->hasIndex('store_id')) $table->dropIndex('store_id');
            if ($table->hasIndex('device_sn')) $table->dropIndex('device_sn');
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
        RC_Schema::table('cashier_device', function(Blueprint $table)
        {
            if (!$table->hasIndex('store_id')) $table->index('store_id', 'store_id');
            if (!$table->hasIndex('device_sn')) $table->index('device_sn', 'device_sn');
        });
    }
}
