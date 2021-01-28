<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddColumnOrderSnToCashierRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! RC_Schema::hasTable('cashier_record')) {
            return ;
        }

        //添加字段
        RC_Schema::table('cashier_record', function (Blueprint $table) {
            if (!RC_Schema::hasColumn('cashier_record', 'order_sn')) $table->string('order_sn', 60)->nullable()->comment('订单编号或退款单编号（order_type是buy或quickpay时存放的是订单编号order_sn，order_type是refund时存放的是退款单编号refund_sn）')->after('order_id');
        });

        //修改字段
        RC_Schema::table('cashier_record', function(Blueprint $table)
        {
            $table->string('order_type', 60)->comment('订单类型（buy消费订单，quickpay收款既买单订单，refund退款单）')->change();
            $table->integer('order_id')->comment('订单id或退款单id（order_type是buy或quickpay时存放的是订单order_id，order_type是refund时存放的是退款单refund_id）')->change();
        });

        //添加索引
        RC_Schema::table('cashier_record', function(Blueprint $table)
        {
            if (!$table->hasIndex('order_sn')) $table->index('order_sn', 'order_sn');
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
        RC_Schema::table('cashier_record', function (Blueprint $table) {
            $table->dropColumn('order_sn');
        });
    }
}
