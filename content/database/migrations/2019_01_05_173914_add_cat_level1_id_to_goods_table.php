<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddCatLevel1IdToGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        RC_Schema::table('goods', function (Blueprint $table) {
            $table->integer('cat_level1_id')->unsigned()->default('0')->comment('一级分类id')->after('store_id');
            $table->integer('cat_level2_id')->unsigned()->default('0')->comment('二级分类id')->after('cat_level1_id');
            $table->integer('merchat_cat_level1_id')->unsigned()->default('0')->comment('商家一级分类id')->after('cat_id');
            $table->integer('merchat_cat_level2_id')->unsigned()->default('0')->comment('商家二级分类id')->after('merchat_cat_level1_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RC_Schema::table('goods', function (Blueprint $table) {
            $table->dropColumn('cat_level1_id');
            $table->dropColumn('cat_level2_id');
            $table->dropColumn('merchat_cat_level1_id');
            $table->dropColumn('merchat_cat_level2_id');
        });
    }
}
