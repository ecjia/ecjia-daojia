<?php

use Royalcms\Component\Database\Migrations\Migration;

class AlterRegionTypeForExpressOrderTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$table = RC_DB::getTableFullName('express_order');
		
		RC_DB::statement("ALTER TABLE `$table` MODIFY `country` VARCHAR(20) NOT NULL DEFAULT '';");
		RC_DB::statement("ALTER TABLE `$table` MODIFY `province` VARCHAR(20) NOT NULL DEFAULT '';");
		RC_DB::statement("ALTER TABLE `$table` MODIFY `city` VARCHAR(20) NOT NULL DEFAULT '';");
		RC_DB::statement("ALTER TABLE `$table` MODIFY `district` VARCHAR(20) NOT NULL DEFAULT '';");
		RC_DB::statement("ALTER TABLE `$table` ADD COLUMN `street` VARCHAR(20) NOT NULL DEFAULT '' COMMENT '街道地区码' AFTER `district`;");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		$table = RC_DB::getTableFullName('express_order');
		
		RC_DB::statement("ALTER TABLE `$table` MODIFY `country` SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0';");
		RC_DB::statement("ALTER TABLE `$table` MODIFY `province` SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0';");
		RC_DB::statement("ALTER TABLE `$table` MODIFY `city` SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0';");
		RC_DB::statement("ALTER TABLE `$table` MODIFY `district` SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0';");
		RC_DB::statement("ALTER TABLE `$table` DROP COLUMN `street`;");
	}

}
