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
        if (RC_Schema::hasTable('affiliate_goods_brokerage')) {
            return ;
        }

        /**
         * 增加商品店铺佣金表
         */
        RC_Schema::create('affiliate_goods_brokerage', function (Blueprint $table) {
            $table->increments('id')->comment('主键id');
            $table->integer('store_id')->unsigned()->default('0')->comment('店铺id');
            $table->integer('goods_id')->unsigned()->default('0')->comment('商品id');
            $table->integer('product_id')->unsigned()->default('0')->comment('货品id');
            $table->decimal('brokerage', 10, 2)->default('0.00')->comment('佣金');

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
