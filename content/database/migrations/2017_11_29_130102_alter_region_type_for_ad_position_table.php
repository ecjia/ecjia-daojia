<?php

use Royalcms\Component\Database\Migrations\Migration;

class AlterRegionTypeForAdPositionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$table = RC_DB::getTableFullName('ad_position');
		
		RC_DB::statement("ALTER TABLE `$table` MODIFY `city_id` VARCHAR(20) NOT NULL DEFAULT '0';");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		$table = RC_DB::getTableFullName('ad_position');
		
		RC_DB::statement("ALTER TABLE `$table` MODIFY `city_id` INT(10) UNSIGNED NOT NULL DEFAULT '0';");
	}

}
