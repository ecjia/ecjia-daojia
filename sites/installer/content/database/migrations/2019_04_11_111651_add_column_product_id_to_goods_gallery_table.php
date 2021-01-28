<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddColumnProductIdToGoodsGalleryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! RC_Schema::hasTable('goods_gallery')) {
            return ;
        }

        //添加字段
        RC_Schema::table('goods_gallery', function (Blueprint $table) {
            if (!RC_Schema::hasColumn('goods_gallery', 'product_id')) $table->integer('product_id')->unsigned()->default('0')->comment('货品ID')->after('goods_id');
            if (!RC_Schema::hasColumn('goods_gallery', 'sort_order')) $table->tinyInteger('sort_order')->default('10')->comment('排序')->after('img_original');
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
        RC_Schema::table('goods_gallery', function (Blueprint $table) {
            $table->dropColumn('product_id');
            $table->dropColumn('sort_order');
        });
    }
}
