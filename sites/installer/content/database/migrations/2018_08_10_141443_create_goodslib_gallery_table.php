<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreateGoodslibGalleryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        if (RC_Schema::hasTable('goodslib_gallery')) {
            return ;
        }

		RC_Schema::create('goodslib_gallery', function(Blueprint $table)
		{
            $table->increments('img_id')->comment('图片id');
            $table->mediumInteger('goods_id')->unsigned()->default('0')->index('goods_id')->comment('商品id');
            $table->string('img_url', 200)->nullable()->comment('图片路径');
            $table->string('img_desc', 200)->nullable()->comment('图片描述');
            $table->string('thumb_url', 200)->nullable()->comment('缩略图路径');
            $table->string('img_original', 200)->nullable()->comment('原始图片');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		RC_Schema::drop('goodslib_gallery');
	}

}
