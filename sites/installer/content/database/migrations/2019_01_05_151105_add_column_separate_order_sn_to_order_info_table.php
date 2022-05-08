<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddColumnSeparateOrderSnToOrderInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! RC_Schema::hasTable('order_info')) {
            return ;
        }

        //添加字段
        RC_Schema::table('order_info', function (Blueprint $table) {
            if (!RC_Schema::hasColumn('order_info', 'separate_order_sn')) $table->string('separate_order_sn', 60)->nullable()->comment('多商家统一结算主订单号');
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
        RC_Schema::table('order_info', function (Blueprint $table) {
            $table->dropColumn('separate_order_sn');
        });
    }
}
