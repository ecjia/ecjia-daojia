<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreateMarketActivityTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		RC_Schema::create('market_activity', function(Blueprint $table)
		{
			$table->increments('activity_id');
			$table->integer('store_id')->unsigned()->default('0')->comment('店铺id');
			$table->string('activity_name', 100)->comment('活动名称');
			$table->tinyInteger('activity_group')->default('0')->comment('活动组（1、摇一摇）');
			$table->text('activity_desc')->nullable()->comment('活动规则描述');
			$table->integer('activity_object')->unsigned()->comment('活动对象（app，pc，touch等）');
			$table->tinyInteger('limit_num')->default('0')->comment('活动限制次数（0为不限制）');
			$table->integer('limit_time')->default('0')->comment('多少时间内活动限制（0为在活动时间内，否则多少时间内限制，单位：分钟）');
			$table->integer('start_time')->unsigned()->default('0')->comment('活动开始时间');
			$table->integer('end_time')->unsigned()->default('0')->comment('活动结束时间');
			$table->integer('add_time')->unsigned()->default('0')->comment('创建时间');
			$table->tinyInteger('enabled')->comment('是否使用，1开启，0禁用');
			
			$table->index('activity_group', 'activity_group');
			$table->index('store_id', 'store_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		RC_Schema::drop('market_activity');
	}

}
