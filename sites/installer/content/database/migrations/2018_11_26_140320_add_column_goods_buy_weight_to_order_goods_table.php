<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddColumnGoodsBuyWeightToOrderGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! RC_Schema::hasTable('order_goods')) {
            return ;
        }

        //添加字段
        RC_Schema::table('order_goods', function (Blueprint $table) {
            if (!RC_Schema::hasColumn('order_goods', 'goods_buy_weight')) $table->decimal('goods_buy_weight', 10, 3)->default('0.000')->comment('散装商品购买总重量')->after('goods_number');
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
        RC_Schema::table('order_goods', function (Blueprint $table) {
            $table->dropColumn('goods_buy_weight');
        });
    }
}
