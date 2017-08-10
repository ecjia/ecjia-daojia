<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddUserTypeToConnectUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		RC_Schema::table('connect_user', function(Blueprint $table)
		{
		    $table->string('user_type', 30)->default('user')->after('user_id');
		});
		
		$table = RC_DB::getTableFullName('connect_user');
		
		RC_DB::statement("ALTER TABLE `$table` MODIFY `connect_code` VARCHAR(30);");
		RC_DB::statement("ALTER TABLE `$table` MODIFY `open_id` VARCHAR(64);");
		RC_DB::statement("ALTER TABLE `$table` MODIFY `refresh_token` VARCHAR(64);");
		RC_DB::statement("ALTER TABLE `$table` MODIFY `access_token` VARCHAR(64);");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		RC_Schema::table('connect_user', function(Blueprint $table)
		{
			$table->dropColumn('user_type');
		});
		
		$table = RC_DB::getTableFullName('connect_user');
		
		RC_DB::statement("ALTER TABLE `$table` MODIFY `connect_code` CHAR(30);");
		RC_DB::statement("ALTER TABLE `$table` MODIFY `open_id` CHAR(64);");
		RC_DB::statement("ALTER TABLE `$table` MODIFY `refresh_token` CHAR(64);");
		RC_DB::statement("ALTER TABLE `$table` MODIFY `access_token` CHAR(64);");
	}

}
