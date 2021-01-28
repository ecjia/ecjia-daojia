<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class RenameIndexStoreCatToGoodsTypeTable extends Migration
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

        //删除索引
        RC_Schema::table('goods_type', function (Blueprint $table) {
            if ($table->hasIndex('store_cat')) $table->dropUnique('store_cat');
        });

        //添加索引
        RC_Schema::table('goods_type', function (Blueprint $table) {
            if (!$table->hasIndex('store_cat')) $table->unique(['store_id', 'cat_name', 'cat_type'], 'store_cat');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        //删除索引
        RC_Schema::table('goods_type', function (Blueprint $table) {
            $table->dropUnique('store_cat');
        });

        //添加索引
        RC_Schema::table('goods_type', function (Blueprint $table) {
            $table->unique(['store_id', 'cat_name'], 'store_cat');
        });
    }
}
