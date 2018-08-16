<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreateGoodslibProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		RC_Schema::create('goodslib_products', function(Blueprint $table)
		{
            $table->increments('product_id');
            $table->mediumInteger('goods_id')->unsigned()->default('0');
            $table->string('goods_attr', 50)->nullable();
            $table->string('product_sn', 60)->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		RC_Schema::drop('goodslib_products');
	}

}
