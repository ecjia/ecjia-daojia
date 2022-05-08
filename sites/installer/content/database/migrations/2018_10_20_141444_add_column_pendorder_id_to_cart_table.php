<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddColumnPendorderIdToCartTable extends Migration
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
            if (!RC_Schema::hasColumn('cart', 'pendorder_id')) $table->integer('pendorder_id')->unsigned()->default('0')->comment('挂单id')->after('is_checked');
            if (!RC_Schema::hasColumn('cart', 'goods_buy_weight')) $table->decimal('goods_buy_weight', 10 ,3)->unsigned()->default('0.000')->comment('散装商品购买总重量')->after('goods_number');
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
            $table->dropColumn('pendorder_id');
            $table->dropColumn('goods_buy_weight');
        });
    }
}
