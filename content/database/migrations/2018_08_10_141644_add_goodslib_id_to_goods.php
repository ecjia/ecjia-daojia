<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddGoodslibIdToGoods extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		RC_Schema::table('goods', function(Blueprint $table)
		{
            $table->integer('goodslib_id')->nullable()->default('0')->comment('商品库商品id');
            $table->integer('goodslib_update_time')->nullable()->default('0')->comment('商品库同步时间');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		RC_Schema::table('goods', function(Blueprint $table)
		{
            $table->dropColumn('goodslib_id');
            $table->dropColumn('goodslib_update_time');
		});
	}

}
