<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddColumnGoodslibIdToGoods extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        if (! RC_Schema::hasTable('goods')) {
            return ;
        }

        //添加字段
		RC_Schema::table('goods', function(Blueprint $table)
		{
            if (!RC_Schema::hasColumn('goods', 'goodslib_id')) $table->integer('goodslib_id')->nullable()->default('0')->comment('商品库商品id');
            if (!RC_Schema::hasColumn('goods', 'goodslib_update_time')) $table->integer('goodslib_update_time')->nullable()->default('0')->comment('商品库同步时间');
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
		RC_Schema::table('goods', function(Blueprint $table)
		{
            $table->dropColumn('goodslib_id');
            $table->dropColumn('goodslib_update_time');
		});
	}

}
