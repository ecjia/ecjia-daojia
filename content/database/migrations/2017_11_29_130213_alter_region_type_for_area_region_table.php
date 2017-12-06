<?php

use Royalcms\Component\Database\Migrations\Migration;

class AlterRegionTypeForAreaRegionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$table = RC_DB::getTableFullName('area_region');
		
		RC_DB::statement("ALTER TABLE `$table` MODIFY `region_id` VARCHAR(20) NOT NULL;");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		$table = RC_DB::getTableFullName('area_region');
		
		RC_DB::statement("ALTER TABLE `$table` MODIFY `region_id` SMALLINT(10) UNSIGNED NOT NULL DEFAULT '0';");
	}

}
