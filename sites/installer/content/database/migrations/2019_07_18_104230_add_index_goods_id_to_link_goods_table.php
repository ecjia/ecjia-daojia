<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddIndexGoodsIdToLinkGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! RC_Schema::hasTable('link_goods')) {
            return ;
        }

        //添加索引
        RC_Schema::table('link_goods', function (Blueprint $table) {
            if (!$table->hasIndex('goods_id')) $table->index('goods_id', 'goods_id');
            if (!$table->hasIndex('link_goods_id')) $table->index('link_goods_id', 'link_goods_id');
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
