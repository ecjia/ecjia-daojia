<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddColumnCatTypeToGoodsAttrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! RC_Schema::hasTable('goods_attr')) {
            return ;
        }

        //添加字段
        RC_Schema::table('goods_attr', function (Blueprint $table) {
            if (!RC_Schema::hasColumn('goods_attr', 'cat_type')) $table->string('cat_type', 60)->nullable()->comment('规格：specification   参数：parameter')->after('goods_attr_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RC_Schema::table('goods_attr', function (Blueprint $table) {
            $table->dropColumn('cat_type');
        });
    }
}
