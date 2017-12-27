<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class DropRegionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		RC_Schema::drop('region');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
	    RC_Schema::create('region', function(Blueprint $table)
		{
		    $table->increments('region_id');
		    $table->smallInteger('parent_id')->unsigned()->default('0')->index('parent_id');
		    $table->string('region_name', 120);
		    $table->tinyInteger('region_type')->default('2')->index('region_type');
		    $table->smallInteger('agency_id')->unsigned()->default('0')->index('agency_id');
		});
	}

}
