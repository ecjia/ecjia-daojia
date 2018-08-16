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
		RC_Schema::create('goodslib_attr', function(Blueprint $table)
		{
            $table->increments('goods_attr_id');
            $table->mediumInteger('goods_id')->unsigned()->index('goods_id');
            $table->smallInteger('attr_id')->unsigned()->default('0')->index('attr_id');
            $table->text('attr_value')->nullable();
            $table->text('color_value')->nullable();
            $table->string('attr_price', 60)->nullable();
            $table->integer('attr_sort')->nullable();
            $table->string('attr_img_flie', 150)->nullable();
            $table->string('attr_gallery_flie', 150)->nullable();
            $table->string('attr_img_site', 150)->nullable();
            $table->tinyInteger('attr_checked')->unsigned()->default('0');
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
