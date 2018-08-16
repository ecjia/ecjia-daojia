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
		RC_Schema::create('goodslib_gallery', function(Blueprint $table)
		{
            $table->increments('img_id');
            $table->mediumInteger('goods_id')->unsigned()->default('0')->index('goods_id');
            $table->string('img_url', 200)->nullable();
            $table->string('img_desc', 200)->nullable();
            $table->string('thumb_url', 200)->nullable();
            $table->string('img_original', 200)->nullable();
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
