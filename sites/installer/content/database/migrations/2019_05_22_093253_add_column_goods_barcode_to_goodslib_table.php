<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddColumnGoodsBarcodeToGoodslibTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! RC_Schema::hasTable('goodslib')) {
            return ;
        }

        //添加字段
        RC_Schema::table('goodslib', function (Blueprint $table) {
            if (!RC_Schema::hasColumn('goodslib', 'cat_level1_id')) $table->smallInteger('cat_level1_id')->default('0')->comment('一级分类id')->after('goods_id');
            if (!RC_Schema::hasColumn('goodslib', 'cat_level2_id')) $table->smallInteger('cat_level2_id')->default('0')->comment('二级分类id')->after('cat_level1_id');
            if (!RC_Schema::hasColumn('goodslib', 'goods_barcode')) $table->string('goods_barcode', 60)->nullable()->comment('商品条形码')->after('goods_sn');
            if (!RC_Schema::hasColumn('goodslib', 'cost_price')) $table->decimal('cost_price', 10, 2)->unsigned()->default('0.00')->comment('商品进货价')->after('shop_price');
            if (!RC_Schema::hasColumn('goodslib', 'limit_days')) $table->string('limit_days', 60)->nullable()->comment('保质期（如：2 day， 2 month，2 year）')->after('cost_price');
            if (!RC_Schema::hasColumn('goodslib', 'specification_id')) $table->integer('specification_id')->unsigned()->default('0')->comment('绑定规格模板')->after('goods_type');
            if (!RC_Schema::hasColumn('goodslib', 'parameter_id')) $table->integer('parameter_id')->unsigned()->default('0')->comment('绑定参数模板')->after('specification_id');
            if (!RC_Schema::hasColumn('goodslib', 'weight_unit')) $table->tinyInteger('weight_unit')->default('1')->comment('商品重量单位：1克，2千克')->after('goods_weight');
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
        RC_Schema::table('goodslib', function (Blueprint $table) {
            $table->dropColumn('cat_level1_id');
            $table->dropColumn('cat_level2_id');
            $table->dropColumn('goods_barcode');
            $table->dropColumn('cost_price');
            $table->dropColumn('limit_days');
            $table->dropColumn('specification_id');
            $table->dropColumn('parameter_id');
            $table->dropColumn('weight_unit');
        });
    }
}
