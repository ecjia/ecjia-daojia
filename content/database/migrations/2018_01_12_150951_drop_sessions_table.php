<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class DropSessionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    RC_Schema::drop('sessions');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
	    RC_Schema::create('sessions', function(Blueprint $table)
	    {
	        $table->char('sesskey', 32)->primary();
		    $table->integer('expiry')->unsigned()->default('0')->index('expiry');
		    $table->mediumInteger('userid')->unsigned()->default('0');
		    $table->mediumInteger('adminid')->unsigned()->default('0');
		    $table->char('ip', 15)->nullable();
		    $table->string('user_name', 60)->nullable();
		    $table->tinyInteger('user_rank')->default('0');
		    $table->decimal('discount', 3, 2)->default('0.00');
		    $table->string('email', 60)->nullable();
		    $table->char('data', 255)->nullable();
	    });
	}

}
