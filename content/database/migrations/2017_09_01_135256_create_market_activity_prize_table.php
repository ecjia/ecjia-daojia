<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreateMarketActivityPrizeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		RC_Schema::create('market_activity_prize', function(Blueprint $table)
		{
			$table->increments('prize_id');
			$table->integer('activity_id')->unsigned()->default('0')->comment('活动id');
			$table->tinyInteger('prize_level')->unsigned()->default('0')->comment('奖项等级（从0开始，0为大奖，依此类推）');
			$table->string('prize_name', 30)->comment('奖品名称');
			$table->integer('prize_type')->unsigned()->comment('奖品类型');
			$table->string('prize_value', 30)->comment('对应奖品信息（id或数量）');
			$table->integer('prize_number')->default('0')->comment('奖品数量（goods与nothing设置无效）');
			$table->decimal('prize_prob', 10, 2)->default('0.00')->comment('奖品数量（概率，总共100%）');
			
			$table->index('activity_id', 'activity_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		RC_Schema::drop('market_activity_prize');
	}

}
