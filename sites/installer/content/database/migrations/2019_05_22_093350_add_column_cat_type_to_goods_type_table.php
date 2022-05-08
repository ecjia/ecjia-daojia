<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddColumnCatTypeToGoodsTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! RC_Schema::hasTable('goods_type')) {
            return ;
        }

        //添加字段
        RC_Schema::table('goods_type', function (Blueprint $table) {
            if (!RC_Schema::hasColumn('goods_type', 'cat_type')) $table->string('cat_type', 60)->nullable()->comment('规格：specification   参数：parameter')->after('cat_name');
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
        RC_Schema::table('goods_type', function (Blueprint $table) {
            $table->dropColumn('cat_type');
        });

    }
}
