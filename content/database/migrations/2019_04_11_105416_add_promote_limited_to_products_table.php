<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddPromoteLimitedToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        RC_Schema::table('products', function (Blueprint $table) {
            $table->string('product_name', 180)->default('0')->comment('货品名称')->after('product_sn');
            $table->decimal('product_shop_price', 10, 2)->unsigned()->nullable()->comment('货品价格')->after('product_name');
            $table->string('product_bar_code', 100)->nullable()->comment('货品条形码')->after('product_shop_price');
            $table->string('product_thumb', 255)->nullable()->comment('货品缩略图')->after('product_bar_code');
            $table->string('product_img', 255)->nullable()->comment('货品大图')->after('product_thumb');
            $table->string('product_original_img', 255)->nullable()->comment('货品原图')->after('product_img');
            $table->text('product_desc')->nullable()->comment('促销限制')->after('product_original_img');
            $table->tinyInteger('is_promote')->unsigned()->default('0')->comment('是否设置促销')->after('product_desc');
            $table->decimal('promote_price', 10, 2)->unsigned()->nullable()->comment('促销价格')->after('is_promote');
            $table->integer('promote_start_date')->unsigned()->default('0')->comment('促销开始时间')->after('promote_price');
            $table->integer('promote_end_date')->unsigned()->default('0')->comment('促销结束时间')->after('promote_start_date');
            $table->smallInteger('promote_limited')->unsigned()->default('0')->comment('促销限制')->after('promote_end_date');
            $table->smallInteger('promote_user_limited')->unsigned()->default('0')->comment('促销用户限购')->after('promote_limited');

            $table->index('is_promote', 'is_promote');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        RC_Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('product_name');
            $table->dropColumn('product_shop_price');
            $table->dropColumn('product_bar_code');
            $table->dropColumn('product_thumb');
            $table->dropColumn('product_img');
            $table->dropColumn('product_original_img');
            $table->dropColumn('product_desc');
            $table->dropColumn('is_promote');
            $table->dropColumn('promote_price');
            $table->dropColumn('promote_start_date');
            $table->dropColumn('promote_end_date');
            $table->dropColumn('promote_limited');
            $table->dropColumn('promote_user_limited');
        });
    }
}
