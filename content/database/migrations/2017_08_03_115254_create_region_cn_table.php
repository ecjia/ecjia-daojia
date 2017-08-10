<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreateRegionCnTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		RC_Schema::create('region_cn', function(Blueprint $table)
		{
			$table->string('region_id', 20)->primary()->comment('地区码');
			$table->string('parent_id', 20)->comment('上级区域编码');
			$table->string('region_name', 120)->comment('区域名称');
			$table->tinyInteger('region_type')->unsigned()->default('1')->comment('区域类型（1省2市3区4街道）');
			$table->char('index_letter', 1)->nullable()->comment('拼音首字母');
			$table->char('country', 2)->default('CN');
			
			$table->index('parent_id', 'parent_id');
			$table->index('region_type', 'region_type');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		RC_Schema::drop('region_cn');
	}

}
