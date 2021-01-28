<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class DropIndexGoodsIdToLinkGoodsTable extends Migration
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

        //删除索引
        RC_Schema::table('link_goods', function (Blueprint $table) {
            $table->dropPrimary();
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
