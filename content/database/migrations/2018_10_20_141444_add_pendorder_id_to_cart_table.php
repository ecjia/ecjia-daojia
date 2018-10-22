<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddPendorderIdToCartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        RC_Schema::table('cart', function (Blueprint $table) {
            $table->integer('pendorder_id')->unsigned()->default('0')->comment('挂单id')->after('is_checked');
            $table->decimal('goods_buy_weight', 10 ,3)->unsigned()->default('0.000')->comment('散装商品购买总重量')->after('goods_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RC_Schema::table('cart', function (Blueprint $table) {
            $table->dropColumn('pendorder_id');
            $table->dropColumn('goods_buy_weight');
        });
    }
}
