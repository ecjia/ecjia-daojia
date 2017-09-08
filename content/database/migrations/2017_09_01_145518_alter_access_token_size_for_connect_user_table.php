<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AlterAccessTokenSizeForConnectUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$table = RC_DB::getTableFullName('connect_user');
		
		RC_DB::statement("ALTER TABLE `$table` MODIFY `refresh_token` VARCHAR(200);");
		RC_DB::statement("ALTER TABLE `$table` MODIFY `access_token` VARCHAR(200);");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		$table = RC_DB::getTableFullName('connect_user');
		
		RC_DB::statement("ALTER TABLE `$table` MODIFY `refresh_token` VARCHAR(64);");
		RC_DB::statement("ALTER TABLE `$table` MODIFY `access_token` VARCHAR(64);");
	}

}
