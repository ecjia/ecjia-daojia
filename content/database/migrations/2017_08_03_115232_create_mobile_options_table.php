<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreateMobileOptionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		RC_Schema::create('mobile_options', function(Blueprint $table)
		{
			$table->increments('option_id');
			$table->string('platform', 60)->nullable()->comment('平台');
			$table->integer('app_id')->unsigned()->default('0')->comment('默认0，取平台配置');
			$table->string('option_name', 120)->comment('选项名称');
			$table->string('option_type', 60)->nullable()->comment('值类型，用于解析数据');
			$table->text('option_value')->nullable()->comment('选项值');
	
			$table->unique(array('platform', 'app_id', 'option_name'), 'platform');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		RC_Schema::drop('mobile_options');
	}

}
