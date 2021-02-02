<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddIsPromoteToCartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        RC_Schema::table('cart', function (Blueprint $table) {
            $table->integer('is_promote')->unsigned()->default('0')->comment('添加购物车时商品是否在促销，0否1是');
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
            $table->dropColumn('is_promote');
        });
    }
}
