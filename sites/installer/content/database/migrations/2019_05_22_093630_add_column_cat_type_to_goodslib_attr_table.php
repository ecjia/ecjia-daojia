<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddColumnCatTypeToGoodslibAttrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! RC_Schema::hasTable('goodslib_attr')) {
            return ;
        }

        //添加字段
        RC_Schema::table('goodslib_attr', function (Blueprint $table) {
            if (!RC_Schema::hasColumn('goodslib_attr', 'cat_type')) $table->string('cat_type', 60)->nullable()->comment('规格：specification   参数：parameter')->after('goods_attr_id');
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
        RC_Schema::table('goodslib_attr', function (Blueprint $table) {
            $table->dropColumn('cat_type');
        });
    }
}
