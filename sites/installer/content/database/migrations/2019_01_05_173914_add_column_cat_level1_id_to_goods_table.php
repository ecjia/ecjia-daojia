<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddColumnCatLevel1IdToGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! RC_Schema::hasTable('goods')) {
            return ;
        }

        //添加字段
        RC_Schema::table('goods', function (Blueprint $table) {
            if (!RC_Schema::hasColumn('goods', 'cat_level1_id')) $table->integer('cat_level1_id')->unsigned()->default('0')->comment('一级分类id')->after('store_id');
            if (!RC_Schema::hasColumn('goods', 'cat_level2_id')) $table->integer('cat_level2_id')->unsigned()->default('0')->comment('二级分类id')->after('cat_level1_id');
            if (!RC_Schema::hasColumn('goods', 'merchat_cat_level1_id')) $table->integer('merchat_cat_level1_id')->unsigned()->default('0')->comment('商家一级分类id')->after('cat_id');
            if (!RC_Schema::hasColumn('goods', 'merchat_cat_level2_id')) $table->integer('merchat_cat_level2_id')->unsigned()->default('0')->comment('商家二级分类id')->after('merchat_cat_level1_id');
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
        RC_Schema::table('goods', function (Blueprint $table) {
            $table->dropColumn('cat_level1_id');
            $table->dropColumn('cat_level2_id');
            $table->dropColumn('merchat_cat_level1_id');
            $table->dropColumn('merchat_cat_level2_id');
        });
    }
}
