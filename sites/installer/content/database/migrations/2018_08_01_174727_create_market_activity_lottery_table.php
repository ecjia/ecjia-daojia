<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreateMarketActivityLotteryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        if (RC_Schema::hasTable('market_activity_lottery')) {
            return ;
        }

		RC_Schema::create('market_activity_lottery', function(Blueprint $table)
		{
			$table->integer('activity_id')->unsigned()->default('0')->comment('营销活动id');
			$table->integer('user_id')->unsigned()->default('0')->comment('根据user_type存放wechat_user表openid或users表user_id');
			$table->string('user_type', 60)->nullable()->default('user')->comment('用户类型，user普通会员，wechat微信用户');
			$table->integer('lottery_num')->unsigned()->default('0')->comment('限定时间段总抽奖次数');
			$table->integer('add_time')->unsigned()->default('0')->comment('限定时间段首次抽奖时间');
			$table->integer('update_time')->unsigned()->default('0')->comment('最新抽奖时间');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		RC_Schema::drop('market_activity_lottery');
	}

}
