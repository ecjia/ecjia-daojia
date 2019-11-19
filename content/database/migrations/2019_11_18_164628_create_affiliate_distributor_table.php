<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreateAffiliateDistributorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        RC_Schema::create('affiliate_distributor', function (Blueprint $table) {
            $table->integer('user_id');
            $table->integer('store_id')->unsigned()->default('0')->comment('店铺id');
            $table->integer('parent_id')->unsigned()->default('0')->comment('上级id');
            $table->integer('grade_id')->unsigned()->default('0')->comment('分销权益ID');
            $table->integer('order_number_total')->unsigned()->default('0')->comment('订单数量');
            $table->decimal('order_amount_total', 10, 2)->unsigned()->default('0.00')->comment('订单金额');
            $table->decimal('brokerage_amount_total', 10, 2)->unsigned()->default('0.00')->comment('佣金金额');
            $table->tinyInteger('limit_days_buy')->unsigned()->default('1')->comment('购买有效期限，单位年');
            $table->integer('expiry_time')->unsigned()->default('0')->comment('到期时间，时间戳');
            $table->integer('add_time')->unsigned()->default('0');

            $table->index('grade_id', 'grade_id');
            $table->index('parent_id', 'parent_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RC_Schema::drop('affiliate_distributor');
    }
}
