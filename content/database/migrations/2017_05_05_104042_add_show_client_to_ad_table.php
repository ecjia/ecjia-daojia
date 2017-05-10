<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class AddShowClientToAdTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		RC_Schema::table('ad', function(Blueprint $table)
		{
		    $table->tinyInteger('sort_order')->unsigned()->nullable()->default('50')->after('enabled');
			$table->integer('show_client')->default('0')->after('sort_order');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		RC_Schema::table('ad', function(Blueprint $table)
		{
			$table->dropColumn('sort_order');
		    $table->dropColumn('show_client');
		});
	}

}
