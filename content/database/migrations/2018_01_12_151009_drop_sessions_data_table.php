<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class DropSessionsDataTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    RC_Schema::drop('sessions_data');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
	    RC_Schema::create('sessions_data', function(Blueprint $table)
	    {
	        $table->char('sesskey', 32)->primary();
		    $table->integer('expiry')->unsigned()->default('0')->index('expiry');
		    $table->longText('data')->nullable();
	    });
	}

}
