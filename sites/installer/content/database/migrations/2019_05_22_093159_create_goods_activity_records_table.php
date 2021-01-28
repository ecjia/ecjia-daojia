<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreateGoodsActivityRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (RC_Schema::hasTable('goods_activity_records')) {
            return ;
        }

        RC_Schema::create('goods_activity_records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('activity_id')->unsigned()->default('0')->comment('商品参与活动id（参与的是促销活动的话默认0）');
            $table->string('activity_type', 60)->comment('商品参与活动类型（promotion促销，groupbuy团购）');
            $table->integer('goods_id')->unsigned()->default('0')->comment('商品id');
            $table->integer('product_id')->unsigned()->default('0')->comment('货品id');
            $table->integer('user_id')->unsigned()->default('0')->comment('用户id');
            $table->integer('buy_num')->unsigned()->default('0')->comment('活动时间段用户总购买数');
            $table->integer('add_time')->nullable()->default('0')->comment('活动时间段内首次购买时间');
            $table->integer('update_time')->nullable()->default('0')->comment('活动时间段内最新购买时间');

            $table->index('activity_id');
            $table->index('activity_type');
            $table->index('goods_id');
            $table->index('product_id');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RC_Schema::drop('goods_activity_records');
    }
}
