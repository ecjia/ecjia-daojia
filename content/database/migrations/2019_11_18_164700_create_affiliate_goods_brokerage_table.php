<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreateAffiliateGoodsBrokerageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * 增加商品店铺佣金表
         */
        RC_Schema::create('affiliate_goods_brokerage', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('store_id')->unsigned()->default('0');
            $table->integer('goods_id')->unsigned()->default('0');
            $table->integer('product_id')->unsigned()->default('0');
            $table->decimal('brokerage', 10, 2)->default('0.00');

            $table->index('store_id', 'store_id');
            $table->index(['goods_id', 'product_id'], 'goods_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RC_Schema::drop('affiliate_goods_brokerage');
    }
}
