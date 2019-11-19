<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreateAffiliateOrderCommissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * 代理商推荐店铺分佣明细表
         */
        RC_Schema::create('affiliate_order_commission', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('store_id')->unsigned()->default('0');
            $table->integer('affiliate_store_id')->unsigned()->default('0')->comment('代理商id');
            $table->string('order_type', 30)->default('buy')->comment('buy订单,quickpay买单,refund退款');
            $table->integer('order_id')->unsigned()->default('0');
            $table->string('order_sn', 60)->comment('订单号');
            $table->decimal('order_amount', 10, 2)->default('0.00')->comment('订单金额');
            $table->decimal('platform_commission', 10, 2)->default('0.00')->comment('平台佣金');
            $table->decimal('percent_value', 10, 2)->unsigned()->default('0.00')->comment('佣金比例');
            $table->decimal('agent_amount', 10, 2)->default('0.00')->comment('佣金金额，平台佣金抽取');
            $table->integer('add_time')->unsigned()->default('0');

            $table->unique(['affiliate_store_id', 'order_sn'], 'order_affiliate_id');
            $table->index('store_id', 'store_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RC_Schema::drop('affiliate_order_commission');
    }
}
