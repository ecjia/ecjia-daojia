<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddColumnProductNameToGoodslibProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! RC_Schema::hasTable('goodslib_products')) {
            return ;
        }

        //添加字段
        RC_Schema::table('goodslib_products', function (Blueprint $table) {
            if (!RC_Schema::hasColumn('goodslib_products', 'product_name')) $table->string('product_name', 180)->default('0')->comment('货品名称')->after('product_sn');
            if (!RC_Schema::hasColumn('goodslib_products', 'product_shop_price')) $table->decimal('product_shop_price', 10, 2)->unsigned()->nullable()->comment('货品价格')->after('product_name');
            if (!RC_Schema::hasColumn('goodslib_products', 'product_bar_code')) $table->string('product_bar_code', 100)->nullable()->comment('货品条形码')->after('product_shop_price');
            if (!RC_Schema::hasColumn('goodslib_products', 'product_thumb')) $table->string('product_thumb', 255)->nullable()->comment('货品缩略图')->after('product_bar_code');
            if (!RC_Schema::hasColumn('goodslib_products', 'product_img')) $table->string('product_img', 255)->nullable()->comment('货品大图')->after('product_thumb');
            if (!RC_Schema::hasColumn('goodslib_products', 'product_original_img')) $table->string('product_original_img', 255)->nullable()->comment('货品原图')->after('product_img');
            if (!RC_Schema::hasColumn('goodslib_products', 'product_desc')) $table->text('product_desc')->nullable()->comment('货品描述')->after('product_original_img');
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
        RC_Schema::table('goodslib_products', function (Blueprint $table) {
            $table->dropColumn('product_name');
            $table->dropColumn('product_shop_price');
            $table->dropColumn('product_bar_code');
            $table->dropColumn('product_thumb');
            $table->dropColumn('product_img');
            $table->dropColumn('product_original_img');
            $table->dropColumn('product_desc');
        });
    }
}
