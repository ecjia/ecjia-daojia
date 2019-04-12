<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddOrderSnToCashierRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        RC_Schema::table('cashier_record', function (Blueprint $table) {
            $table->string('order_sn', 60)->nullable()->comment('订单编号或退款单编号（order_type是buy或quickpay时存放的是订单编号order_sn，order_type是refund时存放的是退款单编号refund_sn）')->after('order_id');

            $table->string('order_type', 60)->comment('订单类型（buy消费订单，quickpay收款既买单订单，refund退款单）')->change();
            $table->integer('order_id')->comment('订单id或退款单id（order_type是buy或quickpay时存放的是订单order_id，order_type是refund时存放的是退款单refund_id）')->change();

            $table->index('order_sn', 'order_sn');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RC_Schema::table('cashier_record', function (Blueprint $table) {
            $table->dropColumn('order_sn');
        });
    }
}
