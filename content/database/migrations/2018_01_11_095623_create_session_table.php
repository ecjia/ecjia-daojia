<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreateSessionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		RC_Schema::create('session', function(Blueprint $table)
		{
			$table->string('id', 190)->unique();
			$table->text('payload');
			$table->integer('last_activity');
			$table->integer('user_id')->nullable();
			$table->string('user_type', 40)->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		RC_Schema::drop('session');
	}

}
