<?php

use Royalcms\Component\Database\Migrations\Migration;

class RenameRegionCnTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		RC_Schema::rename('region_cn', 'regions');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		RC_Schema::rename('regions', 'region_cn');
	}

}
