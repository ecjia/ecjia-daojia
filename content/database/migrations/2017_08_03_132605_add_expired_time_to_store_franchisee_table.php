<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddExpiredTimeToStoreFranchiseeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		RC_Schema::table('store_franchisee', function(Blueprint $table)
		{
			$table->integer('expired_time')->unsigned()->default('0')->comment('过期时间')->after('confirm_time');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		RC_Schema::table('store_franchisee', function(Blueprint $table)
		{
			$table->dropColumn('expired_time');
		});
	}

}
