<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class RecreateCronsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    RC_Schema::drop('crons');
	    
		RC_Schema::create('crons', function(Blueprint $table)
		{
			$table->increments('cron_id');
			$table->string('cron_code', 60);
			$table->string('cron_name', 120);
			$table->text('cron_desc')->nullable();
			$table->tinyInteger('cron_order')->unsigned()->default('0');
			$table->text('cron_config')->nullable();
			$table->string('cron_expression', 60)->nullable()->comment('表达式');
			$table->string('expression_alias', 60)->nullable()->comment('别名');
			$table->integer('runtime')->unsigned()->nullable();
			$table->integer('nexttime')->unsigned()->nullable();
			$table->tinyInteger('enabled')->unsigned()->default('1');
			$table->tinyInteger('run_once')->unsigned()->default('0');
			$table->string('allow_ip', 255)->nullable();
			
			$table->index('nexttime', 'nexttime');
			$table->index('enabled', 'enabled');
			$table->index('cron_code', 'cron_code');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		RC_Schema::drop('crons');
		
		RC_Schema::create('crons', function(Blueprint $table)
		{
		    $table->increments('cron_id');
		    $table->string('cron_code', 30)->index('cron_code');
		    $table->string('cron_name', 120);
		    $table->text('cron_desc')->nullable();
		    $table->tinyInteger('cron_order')->unsigned()->default('0');
		    $table->text('cron_config')->nullable();
		    $table->integer('thistime')->unsigned()->default('0');
		    $table->integer('nextime')->nullable()->index('nextime');
		    $table->tinyInteger('day')->nullable();
		    $table->string('week', 1)->nullable();
		    $table->string('hour', 2)->nullable();
		    $table->string('minute', 255)->nullable();
		    $table->tinyInteger('enable')->unsigned()->default('1')->index('enable');
		    $table->tinyInteger('run_once')->unsigned()->default('0');
		    $table->string('allow_ip', 100)->nullable();
		    $table->string('alow_files', 255)->nullable();
		});
	}

}
