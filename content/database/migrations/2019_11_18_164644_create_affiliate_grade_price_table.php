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
        RC_Schema::create('affiliate_grade_price', function (Blueprint $table) {
            $table->increments('price_id');
            $table->integer('goods_id')->unsigned()->default('0');
            $table->integer('grade_id')->unsigned()->default('0');
            $table->decimal('grade_price', 10, 2)->unsigned()->default('0.00');

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
