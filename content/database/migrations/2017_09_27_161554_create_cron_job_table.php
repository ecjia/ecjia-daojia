<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreateCronJobTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		RC_Schema::create('cron_job', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('name', 160);
            $table->text('return')->nullable();
            $table->float('runtime');
            $table->integer('cron_manager_id')->unsigned();
            $table->index(array('name', 'cron_manager_id'), 'name');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		RC_Schema::drop('cron_job');
	}

}
