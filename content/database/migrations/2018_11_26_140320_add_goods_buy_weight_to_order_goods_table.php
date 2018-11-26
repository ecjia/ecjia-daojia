<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddGoodsBuyWeightToOrderGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        RC_Schema::table('order_goods', function (Blueprint $table) {
            $table->decimal('goods_buy_weight', 10, 3)->default('0.000')->comment('散装商品购买总重量')->after('goods_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RC_Schema::table('order_goods', function (Blueprint $table) {
            $table->dropColumn('goods_buy_weight');
        });
    }
}
