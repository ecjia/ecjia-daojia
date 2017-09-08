<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreateMarketActivityLogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		RC_Schema::create('market_activity_log', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('activity_id')->unsigned()->default('0')->comment('活动id');
			$table->integer('user_id')->unsigned()->default('0')->comment('会员id');
			$table->string('username', 25)->comment('会员名称');
			$table->integer('prize_id')->unsigned()->default('0')->comment('奖品池id');
			$table->string('prize_name', 30)->comment('奖品名称');
			$table->tinyInteger('issue_status')->unsigned()->default('0')->comment('发放状态，0未发放，1发放');
			$table->integer('issue_time')->unsigned()->default('0')->comment('（奖品）发放时间');
			$table->text('issue_extend')->nullable()->comment('需线下延期发放的扩展信息（序列化）');
			$table->integer('add_time')->unsigned()->default('0')->comment('抽奖时间');
			$table->string('source', 20)->comment('来源（app，touch，pc等）');
			
			$table->index('activity_id', 'activity_id');
			$table->index('prize_id', 'prize_id');
			$table->index('user_id', 'user_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		RC_Schema::drop('market_activity_log');
	}

}
