<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddColumnPriceTypeToCartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! RC_Schema::hasTable('cart')) {
            return ;
        }

        //添加字段
        RC_Schema::table('cart', function (Blueprint $table) {
            if (!RC_Schema::hasColumn('cart', 'price_type')) $table->string('price_type', 30)->default('')->comment('加入购物车时商品价格类型（origin原价、user会员价、volume数量优惠价、promote促销价）');
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
        RC_Schema::table('cart', function (Blueprint $table) {
            $table->dropColumn('price_type');
        });
    }
}
