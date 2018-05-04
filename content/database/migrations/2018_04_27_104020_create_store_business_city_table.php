<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreateStoreBusinessCityTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		RC_Schema::create('store_business_city', function(Blueprint $table)
		{
			$table->string('business_city', 20)->comment('开通服务城市地区码，同ecjia_region_cn表region_id字段');
			$table->string('business_city_name', 120)->comment('城市名同ecjia_region_cn表region_name字段');
			$table->string('business_city_alias', 120)->comment('开通服务城市别名');
			$table->char('index_letter', 1)->comment('城市拼音首字母');
			$table->text('business_district')->comment('当前开通服务城市已开通的地区，地区码以字符串形式存放如：CN330502,CN220681');
			
			$table->unique('business_city', 'business_city');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		RC_Schema::drop('store_business_city');
	}

}
