<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreateGoodslibAttrTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        if (RC_Schema::hasTable('goodslib_attr')) {
            return ;
        }

		RC_Schema::create('goodslib_attr', function(Blueprint $table)
		{
            $table->increments('goods_attr_id')->comment('商品规格id');
            $table->mediumInteger('goods_id')->unsigned()->index('goods_id')->comment('商品id');
            $table->smallInteger('attr_id')->unsigned()->default('0')->index('attr_id')->comment('规格id');
            $table->text('attr_value')->nullable()->comment('规格属性值');
            $table->text('color_value')->nullable()->comment('颜色值');
            $table->string('attr_price', 60)->nullable()->comment('规格属性价格');
            $table->integer('attr_sort')->nullable()->comment('规格属性排序');
            $table->string('attr_img_flie', 150)->nullable()->comment('规格属性图片文件');
            $table->string('attr_gallery_flie', 150)->nullable()->comment('规格属性商品相册文件');
            $table->string('attr_img_site', 150)->nullable()->comment('规格属性图片站点');
            $table->tinyInteger('attr_checked')->unsigned()->default('0')->comment('规格属性核对');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		RC_Schema::drop('goodslib_attr');
	}

}
