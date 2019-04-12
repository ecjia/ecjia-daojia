<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddProductIdToGoodslibGalleryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        RC_Schema::table('goodslib_gallery', function (Blueprint $table) {
            $table->integer('product_id')->unsigned()->default('0')->comment('货品ID')->after('goods_id');
            $table->tinyInteger('sort_order')->default('10')->comment('排序')->after('img_original');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RC_Schema::table('goodslib_gallery', function (Blueprint $table) {
            $table->dropColumn('product_id');
            $table->dropColumn('sort_order');
        });
    }
}
