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
        if (RC_Schema::hasTable('goodslib_products')) {
            return ;
        }

		RC_Schema::create('goodslib_products', function(Blueprint $table)
		{
            $table->increments('product_id')->comment('货品id');
            $table->mediumInteger('goods_id')->unsigned()->default('0')->comment('商品id');
            $table->string('goods_attr', 50)->nullable()->comment('商品规格属性');
            $table->string('product_sn', 60)->nullable()->comment('货号');
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
