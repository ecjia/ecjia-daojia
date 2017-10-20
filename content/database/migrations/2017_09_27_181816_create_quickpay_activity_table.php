<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreateQuickpayActivityTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		RC_Schema::create('quickpay_activity', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('store_id')->unsigned()->default('0')->comment('商家店铺ID');
			$table->string('title', 100)->comment('闪惠标题');
			$table->string('description', 255)->nullable()->comment('闪惠描述');
			$table->string('quickpay_type', 60)->default('quickpay')->comment('闪惠类型');
			$table->string('activity_type', 60)->default('normal')->comment('normal无优惠, discount价格折扣, everyreduced每满多少减多少,最高减多少, reduced满多少减多少');
			$table->string('activity_value', 255)->nullable()->comment('活动参数配置 1、空 2、90为9折 3、500,200 4、100,10,50');
			$table->string('limit_time_type', 60)->default('nolimit')->comment('限制时间类型类型说明：nolimit不限制时间, customize自定义时间');
			$table->integer('limit_time_weekly')->default('0')->comment('每周星期0b1111111代表7天');
			$table->text('limit_time_daily')->nullable()->comment('每天时间段');
			$table->text('limit_time_exclude')->nullable()->comment('排除日期 逗号分隔存储，如2017-01-01,2017-02-01');
			$table->integer('start_time')->unsigned()->default('0')->comment('闪惠规则开始时间');
			$table->integer('end_time')->unsigned()->default('0')->comment('闪惠规则结束时间');
			$table->string('use_integral', 60)->default('close')->comment('使用最大积分多少 类型说明：close 不能使用，nolimit 不限使用，20（数字）最大可用积分');
			$table->string('use_bonus', 200)->default('close')->comment('允许使用红包类型，逗号分隔存储，类型说明：close 不能使用， nolimit 不限使用， 红包id，指定使用');
			$table->tinyInteger('enabled')->unsigned()->default('1')->comment('0 关闭，1 开启');
			
			$table->index('store_id', 'store_id');
			$table->index('quickpay_type', 'quickpay_type');
			$table->index('activity_type', 'activity_type');
			$table->index('limit_time_type', 'limit_time_type');
			$table->index('limit_time_weekly', 'limit_time_weekly');
			$table->index('enabled', 'enabled');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		RC_Schema::drop('quickpay_activity');
	}

}
