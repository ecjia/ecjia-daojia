<?php

use Royalcms\Component\Database\Migrations\Migration;

class AlterInStatusForMobileDeviceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$table = RC_DB::getTableFullName('mobile_device');
		RC_DB::statement("ALTER TABLE `$table` CHANGE `in_status` `in_status` TINYINT(3)  NOT NULL  DEFAULT '0';");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		$table = RC_DB::getTableFullName('mobile_device');
		RC_DB::statement("ALTER TABLE `$table` CHANGE `in_status` `in_status` TINYINT(3)  NULL  DEFAULT NULL;");
	}

}
