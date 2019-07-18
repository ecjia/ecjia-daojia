<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AlterAddIndexGoodsIdToLinkGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        RC_Schema::table('link_goods', function (Blueprint $table) {
            $table->dropPrimary();
        });

        RC_Schema::table('link_goods', function (Blueprint $table) {
            $table->index('goods_id', 'goods_id');
            $table->index('link_goods_id', 'link_goods_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
