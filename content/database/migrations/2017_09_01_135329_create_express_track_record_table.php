<?php

use Royalcms\Component\Database\Schema\Blueprint;
use Royalcms\Component\Database\Migrations\Migration;

class CreateExpressTrackRecordTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		RC_Schema::create('express_track_record', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('express_code', 30)->comment('对应配送方式表中shipping_code');
			$table->string('track_number', 30)->comment('运单号');
			$table->dateTimeTz('time')->nullable()->comment('时间');
			$table->string('context', 200)->nullable()->comment('描述');
			
			$table->index('track_number', 'track_number');
			$table->index('express_code', 'express_code');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		RC_Schema::drop('express_track_record');
	}

}
