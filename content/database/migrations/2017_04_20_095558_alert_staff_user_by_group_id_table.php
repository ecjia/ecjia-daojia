<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AlertStaffUserByGroupIdTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		RC_Schema::table('staff_user', function(Blueprint $table)
		{
			$table->integer('group_id')->default('0')->change();
            $table->integer('parent_id')->unsigned()->default('0')->change();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		RC_Schema::table('staff_user', function(Blueprint $table)
		{
			//
		});
	}

}
