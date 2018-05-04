<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddCommisionStatusForExpressOrderTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		RC_Schema::table('express_order', function(Blueprint $table)
		{
		    $table->tinyInteger('commision_status')->unsigned()->default('0')->comment('配送费用结算状态（1已结算，0未结算）')->after('commision');
		    $table->integer('commision_time')->unsigned()->default('0')->comment('配送费用结算时间')->after('commision_status');
		    $table->string('shipping_code', 60)->nullable()->comment('配送方式代号')->after('shipping_fee');
		});
		
		RC_Schema::table('express_order', function(Blueprint $table)
		{
		    $table->dropIndex('order_id');
		    $table->dropIndex('store_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		RC_Schema::table('express_order', function(Blueprint $table)
		{
		    $table->dropColumn('commision_status');
		    $table->dropColumn('commision_time');
		    $table->dropColumn('shipping_code');
		});
		
		RC_Schema::table('express_order', function(Blueprint $table)
		{
		    $table->index('order_id', 'order_id');
		    $table->index('store_id', 'store_id');
		});
	}

}
