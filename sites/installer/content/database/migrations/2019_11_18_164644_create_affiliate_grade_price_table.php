<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreateAffiliateGradePriceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (RC_Schema::hasTable('affiliate_grade_price')) {
            return ;
        }

        RC_Schema::create('affiliate_grade_price', function (Blueprint $table) {
            $table->increments('price_id')->comment('主键id');
            $table->integer('goods_id')->unsigned()->default('0')->comment('商品id');
            $table->integer('grade_id')->unsigned()->default('0')->comment('等级id');
            $table->decimal('grade_price', 10, 2)->unsigned()->default('0.00')->comment('等级价格');

            $table->index(['goods_id', 'grade_id'], 'goods_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RC_Schema::drop('affiliate_grade_price');
    }
}
