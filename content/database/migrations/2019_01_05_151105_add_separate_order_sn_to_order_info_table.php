<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddSeparateOrderSnToOrderInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        RC_Schema::table('order_info', function (Blueprint $table) {
            $table->string('separate_order_sn', 60)->nullable()->comment('多商家统一结算主订单号');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RC_Schema::table('order_info', function (Blueprint $table) {
            $table->dropColumn('separate_order_sn');
        });
    }
}
